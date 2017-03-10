<?php

namespace Inventory\Services;

use Inventory\Entity\PurchaseOrder\Address;
use Inventory\Entity\PurchaseOrder\AddressType;
use Inventory\Entity\PurchaseOrder\Item;
use Inventory\Entity\Supplier;
use Inventory\Entity\Location;
use Inventory\Entity\Product;
use Inventory\Entity\PurchaseOrder\PurchaseOrder;
use Doctrine\Common\Collections\ArrayCollection;
use Inventory\Entity\PurchaseOrder\Address as PurchaseOrderAddress;
use Inventory\Entity\PurchaseOrder\Exception as PurchaseOrderException;

class PurchaseOrderService implements PurchaseOrderServiceInterface
{
    /**
     * @var PurchaseOrder[]
     */
    protected $purchaseOrders;

    /**
     * @var Product[]
     */
    protected $products;

    /**
     * @var Supplier[]
     */
    protected $suppliers;

    /**
     * @var Location
     */
    protected $shippingLocation;

    /**
     * @var Location
     */
    protected $billingLocation;

    /**
     * array
     */
    protected $messages;

    /**
     * @var bool
     */
    protected $itemQtysCalculated;

    /**
     * @var Location
     */
    protected $location;

    /**
     * Factory constructor.
     */
    public function __construct()
    {
        $this->purchaseOrders = new ArrayCollection();
        $this->products = new ArrayCollection();
        $this->suppliers = new ArrayCollection();
        $this->itemQtysCalculated = false;
    }

    /**
     * Loop over products and organise into groups by supplier.
     * Creates one purchase order for each supplier
     */
    public function createPurchaseOrders()
    {
        // Hint: Dealing with Product\Supplier entities

        // Make a unique array of primary suppliers
        /* @var Product $product */
        foreach ($this->products as $product) {

            /** @var Product\Supplier $primarySupplier */
            $primarySupplier = $product->getPrimarySupplier();

            if ($primarySupplier) {
                if (!$this->suppliers->contains($primarySupplier->getSupplier())) {
                    // Add current product to suppliers array
                    $this->suppliers->add($primarySupplier->getSupplier());
                }
            } else {
                $this->addMessage(sprintf("Product '%s (%s)' has no primary supplier. Please fix before continuing.",
                    $product->getName(),
                    $product->getSku()
                ));
            }
        }

        try {
            // Create purchase orders, one for each supplier
            foreach ($this->suppliers as $supplier) {

                // Filter out products belonging to this supplier
                $products = $this->products->filter(function ($product) use ($supplier) {
                    return ($product->getPrimarySupplier()->getSupplier() == $supplier);
                });

                $purchaseOrder = new PurchaseOrder();
                $purchaseOrder->setLocation($this->shippingLocation);
                // Sets automatic default Billing and Shipping addresses
                $purchaseOrder->setShippingAddress($this->getShippingAddress($this->shippingLocation));
                $purchaseOrder->setBillingAddress($this->getBillingAddress($this->billingLocation));
                if (null !== ($supplierAddress = $this->getSupplierAddress($supplier))) {
                    $purchaseOrder->setSupplierAddress($supplierAddress);
                }
                $purchaseOrder->setSupplier($supplier);

                $this->attachProducts($purchaseOrder, $products);

                /*
                1. Calculate totals
                2. Calculate order qty
                3. Set supplier info (name, reference terms)
                4. ...
                */
                if (!$purchaseOrder->getItems()->count()) {
                    throw new PurchaseOrderException('Missing items');
                }

                $this->calculateItemsQty($purchaseOrder);

                $purchaseOrder->calculateTotals();

                $purchaseOrder->setSupplierName($supplier->getName());
                $purchaseOrder->setSupplierReference($supplier->getReference());
                $purchaseOrder->setTerms($supplier->getTerms());
                // $this->setNumber($this->requestNumber());

                // TODO: set status
                // Need entity manager..

                $this->purchaseOrders->add($purchaseOrder);
            }
        } catch (PurchaseOrderException $e) {
            $this->addMessage($e->getMessage());
        }

        return $this;
    }

    public function addProducts($products)
    {
        foreach ($products as $product) {
            $this->products->add($product);
        }
        return $this;
    }

    public function setShippingLocation(Location $location)
    {
        $this->shippingLocation = $location;
        return $this;
    }

    public function setBillingLocation(Location $location)
    {
        $this->billingLocation = $location;
        return $this;
    }

    public function getPurchaseOrders()
    {
        return $this->purchaseOrders;
    }

    protected function getAddressFromLocation(Location $location)
    {
        $addressLines = explode("\n", $location->getAddress());
        // Assume town is last line in address?
        if (count($addressLines) > 1) {
            $town = array_pop($addressLines);
        } else {
            $town = '';
        }

        // Create and return PurchaseOrder\Address entity
        $address = new PurchaseOrderAddress();
        $address
            ->setAddress($addressLines[0])
            ->setAddress1(isset($addressLines[1]) ? $addressLines[1] : null)
            ->setAddress2(isset($addressLines[2]) ? $addressLines[2] : null)
            ->setTown($town)
            ->setPostcode($location->getPostCode());
        // We don't have any of these values at from Location entity
        //->setCompanyName()
        //->setCounty()
        //->setCountry()
        //->setTitle()
        //->setFirstName()
        //->setLastName();
        return $address;
    }

    protected function getShippingAddress(Location $location)
    {
        $address = $this->getAddressFromLocation($location);
        $address->setAddressType(new AddressType(AddressType::SHIPPING));
        return $address;
    }

    protected function getBillingAddress(Location $location)
    {
        $address = $this->getAddressFromLocation($location);
        $address->setAddressType(new AddressType(AddressType::BILLING));
        // Add user title, first and last name?
        return $address;
    }

    /**
     * Returns a PurchaseOrder\Address instance for the supplier
     *
     * @param Supplier $supplier
     * @return Address
     */
    protected function getSupplierAddress(Supplier $supplier)
    {
        // Create address
        $address = new PurchaseOrderAddress(new AddressType(AddressType::SUPPLIER));

        // Automatically set supplier address to the supplier's primary address
        /** @var \Inventory\Entity\User\Address $supplierAddress */
        $supplierAddress = $supplier->getUser()->getPrimaryAddress();

        if ($supplierAddress) {
            $address
                ->setAddress($supplierAddress->getAddress())
                ->setAddress1($supplierAddress->getAddress1())
                ->setAddress2($supplierAddress->getAddress2())
                ->setTown($supplierAddress->getTown())
                ->setPostcode($supplierAddress->getPostCode())
                ->setCounty($supplierAddress->getCounty())
                ->setCountry($supplierAddress->getCountry())
                ->setCompanyName($supplier->getName())
                ->setFirstName($supplier->getUser()->getFirstName())
                ->setLastName($supplier->getUser()->getLastName());

            if (null !== ($title = $supplier->getUser()->getTitle())) {
                $address->setTitle($title->getTitle());
            }
        } else {
            $this->addMessage(sprintf(
                "Supplier '%s' has no primary address. Please fix before continuing.",
                $supplier->getName()
            ));
            $address = null;
        }

        return $address;
    }

    /**
     * We must calculate order qty at the PurchaseOrder level because we need to know the ship-to location and supplier
     * for stock and order params
     *
     * @param PurchaseOrder $purchaseOrder
     * @return void
     * @throws PurchaseOrderException
     */
    protected function calculateItemsQty(PurchaseOrder $purchaseOrder)
    {
        if ($this->itemQtysCalculated) {
            return;
        }

        if (!$purchaseOrder->isValid()) {
            return;
        }

        /* @var \Inventory\Entity\PurchaseOrder\Item $orderItem */
        /* @var \Inventory\Entity\Product\Supplier $productSupplier */
        foreach ($purchaseOrder->getItems() as $itemKey => $orderItem) {

            // Get the supplier ordering params for this product.
            $productSupplier = $orderItem->getProduct()->getSupplier($purchaseOrder->getSupplier());

            // Default to supplier minOrder if no inventory found at location
            $minOrder = $productSupplier->getMinOrder() ? (int)$productSupplier->getMinOrder() : 1;

            // Get inventory based on shipping location
            $locationInventory = $orderItem->getProduct()->getInventoryForLocation($purchaseOrder->getLocation());

            // Set targetStock for calculating reorder quantity
            $targetStock = ($locationInventory) ? (int)$locationInventory->getMaxStockQty() : $minOrder;

            if ((int)$targetStock == 0) {
                throw new PurchaseOrderException(sprintf(
                    "Location '%s' target stock quantity cannot be 0 for product '%s'",
                    $this->location->getName(),
                    $orderItem->getProduct()->getName()
                ));
            }

            /* TODO: refactor to use Respository\Location\Stock::getStockQuantity() */
            $curStockLevel = $orderItem->getProduct()->getStockLevels()->first();

            // Default to 0 if no stock data present
            $stockQty = $curStockLevel ? (int)$curStockLevel->getQuantity() : 0;

            if ($stockQty < $targetStock) {
                $orderQty = $targetStock - $stockQty;
            } else {
                $orderQty = $minOrder;
            }

            // order qty must be increment of supplier ordering UOM
            $orderingUOM = max($productSupplier->getOrderingUOM(), 1);
            $remainder = ($orderQty % $orderingUOM);
            if ($remainder != 0) {
                $orderQty = ceil($orderQty / $orderingUOM) * $orderingUOM;
            }

            $orderItem->setQty($orderQty);
        }

        $this->itemQtysCalculated = true;
    }


    /**
     * Add products to a purchase order and turns them into purchase order items
     * @param PurchaseOrder $purchaseOrder
     * @param array|ArrayCollection $products
     * @return $this
     * @throws PurchaseOrderException
     */
    protected function attachProducts(PurchaseOrder $purchaseOrder, $products)
    {
        foreach ($products as $product) {
            $item = new Item();
            $item->setProduct($product)
                ->setName($product->getName())
                ->setTaxrate($product->getTaxrate()->getRate());

            // Calculate supplier
            $productSupplier = $product->getPrimarySupplier();
            if (!$productSupplier) {
                throw new PurchaseOrderException(sprintf(
                    "Product '%s' does not have a primary supplier.",
                    $product->getName()
                ));
            }
            $item->setSku($product->getSku());
            $item->setBarcode($productSupplier->getSupplierCode());
            $item->setUnitPrice($productSupplier->getCost());

            $purchaseOrder->addItems([$item]);
        }
        return $this;
    }

    protected function addMessage($message)
    {
        $this->messages[] = $message;
        return $this;
    }

    public function getMessages()
    {
        return $this->messages;
    }
}
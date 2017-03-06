<?php

//require 'defines.php';
require __DIR__ . '/../../vendor/autoload.php';

// Not autoloading as expected in autoload-dev so include manually
require __DIR__ . '/../../vendor/phpunit/phpunit/src/Framework/Assert/Functions.php';

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

use Inventory\Entity\Location;
use Inventory\Entity\Location\ProductInventory;
use Inventory\Entity\PurchaseOrder\Factory as PurchaseOrderFactory;
use Inventory\Entity\PurchaseOrder\PurchaseOrder;
use Inventory\Entity\Product;
use Inventory\Entity\Product\Supplier as ProductSupplier;
use Inventory\Entity\Supplier;
use Inventory\Entity\Taxrate;
use Inventory\Entity\User;
use Inventory\Entity\User\Address as SupplierAddress;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    /**
     * @var Product
     */
    private $product;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $products;

    /**
     * @var Location
     */
    private $location;

    /**
     * @var PurchaseOrder
     */
    private $purchaseOrder;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $purchaseOrders;

    /**
     * @var Supplier
     */
    private $supplier;

    /**
     * @var ArrayCollection
     */
    private $suppliers;

    /**
     * @var PurchaseOrderFactory
     */
    private $factory;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->location = new Location();
        $this->location->setName('Test Store');
        $this->location->setAddress("St Nicholas Square\nNewcastle upon Tyne");
        $this->location->setPostcode("NE1 2TT");

        $this->userLocation = new Location();
        $this->userLocation->setName('Head Office');
        $this->userLocation->setAddress("12 Waskerley Way\nConsett");
        $this->userLocation->setPostcode("DH8 5YH");

        $this->products = new ArrayCollection;
        $this->suppliers = new ArrayCollection;
        $this->purchaseOrders = new ArrayCollection;
    }

    /**
     * @Given that I have product :name
     */
    public function thatIHaveProduct($name)
    {
        $this->product = new Product;
        $this->product->setName($name);
        // Product primary supplier
        // $this->theProductHasPrimarySupplierWithCost('Supplier One', 18);
        $taxrate = new Taxrate();
        $taxrate->setRate(20);
        $taxrate->setName('VAT');
        $taxrate->setActive(true);
        $this->product->setTaxrate($taxrate);
    }

    /**
     * Alias thatIHaveProduct
     * @Given I have product :arg1
     */
    public function iHaveProduct($arg1)
    {
        $this->thatIHaveProduct($arg1);
    }

    /**
     * @Given there are :qty in stock
     */
    public function thereAreInStock($qty)
    {
        // Create a Location Stock object
        $locationStock = new Location\Stock();
        $locationStock->setProduct($this->product);
        $locationStock->setLocation($this->location);
        $locationStock->setQuantity($qty);
        $this->product->addStockLevels([$locationStock]);
    }

    /**
     * @Given the reorder level is :minStockQty
     */
    public function theReorderLevelIs($minStockQty)
    {
        $locationInventory = new ProductInventory();
        $locationInventory->setMinStockQty($minStockQty)
            ->setManageStock(true)
            ->setProduct($this->product)
            ->setLocation($this->location);
        $this->product->addLocationInventory([$locationInventory]);
    }

    /**
     * @Given my target stock level is :maxStockQty
     */
    public function myTargetStockLevelIs($maxStockQty)
    {
        $locationInventory = $this->product->getInventoryForLocation($this->location);
        /* @var ProductInventory $locationInventory */
        $locationInventory->setMaxStockQty($maxStockQty);
    }

    /**
     * @When I create a purchase order
     */
    public function iCreateAPurchaseOrder()
    {
        $factory = new PurchaseOrderFactory;

        $factory->setShippingLocation($this->location)
            ->setBillingLocation($this->userLocation)
            ->addProducts([$this->product])
            ->create();

        $this->factory = $factory;

        $this->purchaseOrder = $factory->getPurchaseOrders()->first();
    }

    /**
     * @Then the product :name should have an order quantity of :qty
     */
    public function theProductShouldHaveAnOrderQuantityOf($name, $qty)
    {
        $orderItems = $this->purchaseOrder->getItems();
        $found = null;
        foreach ($orderItems as $item) {
            if ($item->getName() == $name) {
                $found = true;
                break;
            }
        }
        if (!$found) {
            throw new Exception('Product not found in order items');
        }
        /* @var \Inventory\Entity\PurchaseOrder\Item $item */
        assertEquals($qty, $item->getQty(), 'Item qty does not match expected');
    }

    /**
     * @Given the product has primary supplier :name with cost :cost
     */
    public function theProductHasPrimarySupplierWithCost($name, $cost)
    {
        $supplier = $this->getSupplier($name);

        $this->supplier = $supplier;

        $productSupplier = new ProductSupplier();
        $productSupplier->setProduct($this->product)
            ->setCost($cost)
            ->setActive(true)
            ->setSupplier($supplier)
            ->setPrimarySupplier(true);
        $this->product->addSuppliers([$productSupplier]);
    }

    /**
     * @Given the product has supplier :name with cost :cost
     */
    public function theProductHasSupplierWithCost($name, $cost)
    {
        $supplier = $this->getSupplier($name);

        $productSupplier = new ProductSupplier();
        $productSupplier->setProduct($this->product)
            ->setCost($cost)
            ->setActive(true)
            ->setSupplier($supplier)
            ->setPrimarySupplier(false);
        $this->product->addSuppliers([$productSupplier]);
    }

    /**
     * @Then the supplier should be :name
     */
    public function theSupplierShouldBe($name)
    {
        if ($this->purchaseOrder->getSupplier()->getName() != $name) {
            throw new Exception('Supplier is not the primary supplier');
        }
    }

    /**
     * @Then the product price should be :price
     */
    public function theProductPriceShouldBe($price)
    {
        /* @var \Inventory\Entity\PurchaseOrder\Item $orderItem */
        $orderItem = $this->purchaseOrder->getItems()->first();
        assertEquals($price, $orderItem->getUnitPrice(), 'Unit price does not match that of primary supplier cost');
    }

    /**
     * @When I fetch the primary supplier
     */
    public function iFetchThePrimarySupplier()
    {
        // var_dump($this->product->getSuppliers()->toArray());
        $this->primarySupplier = $this->product->getPrimarySupplier();
    }

    /**
     * @Then the product supplier should be :name
     */
    public function theProductSupplierShouldBe($name)
    {
        $expected = $this->primarySupplier->getSupplier()->getName();
        assertEquals($name, $expected, 'Primary supplier does not match expected');

    }

    /**
     * @Then the supplier price should be :cost
     */
    public function theSupplierPriceShouldBe($cost)
    {
        if ($this->primarySupplier->getCost() !== $cost) {
            throw new Exception('Primary supplier cost should be ' . $cost);
        }
    }

    /**
     * @Then the product :name should have an order quantity greater or equal to :qty
     */
    public function theProductShouldHaveAnOrderQuantityGreaterOrEqualTo($name, $qty)
    {
        foreach ($this->purchaseOrder->getItems() as $item) {
            if ($item->getName() == $name) {
                assertGreaterThanOrEqual($qty, $item->getQty(), 'Item quantity does not match expected');
            }
        }
    }

    /**
     * @Given the product has primary supplier :name
     */
    public function theProductHasPrimarySupplier($name)
    {
        $supplier = $this->getSupplier($name);

        $this->supplier = $supplier;

        $productSupplier = new ProductSupplier();
        $productSupplier->setProduct($this->product)
            ->setActive(true)
            ->setSupplier($supplier)
            ->setPrimarySupplier(true);
        $this->product->addSuppliers([$productSupplier]);
    }

    /**
     * @Given supplier :name has :attr :value
     */
    public function supplierHas($name, $attr, $value)
    {
        $found = false;
        foreach ($this->product->getSuppliers() as $productSupplier) {
            if ($productSupplier->getSupplier()->getName() == $name) {
                $setter = 'set' . str_replace(' ', '', ucwords($attr));
                call_user_func([$productSupplier, $setter], $value);
                $found = true;
            }
        }
        if (!$found) {
            throw new Exception('Supplier with name "' . $name . '" not found. Unable to set "' . $attr . '"');
        }
    }

    /**
     * @Given I have products:
     */
    public function iHaveProducts(TableNode $table)
    {
        foreach ($table as $row) {
            $product = new Product;
            $product->setId($row['id']);
            $product->setName($row['name']);

            $supplier = $this->getSupplier($row['supplier']);
            if (!$supplier) {
                $supplier = new Supplier();
                $supplier->setName($row['supplier']);
                $this->suppliers->set($supplier->getName(), $supplier);
            }

            $productSupplier = new Product\Supplier();
            $productSupplier->setSupplier($supplier);
            $productSupplier->setActive(true);
            $productSupplier->setPrimarySupplier($row['primary']);
            $product->addSuppliers([$productSupplier]);

            $taxrate = new Taxrate();
            $taxrate->setRate(20);
            $taxrate->setName('VAT');
            $taxrate->setActive(true);
            $product->setTaxrate($taxrate);

            $this->products->add($product);
        }
    }

    /**
     * @When I create purchase orders
     */
    public function iCreatePurchaseOrders()
    {
        $factory = new PurchaseOrderFactory();
        $factory->setShippingLocation($this->location)
            ->setBillingLocation($this->userLocation)
            ->addProducts($this->products)
            ->create();
        $this->purchaseOrders = $factory->getPurchaseOrders();
    }

    /**
     * @Then it should return :count purchase orders
     */
    public function itShouldReturnPurchaseOrders($count)
    {
        assertEquals($count, $this->purchaseOrders->count());
    }

    /**
     * @Then purchase order for supplier :name contains items:
     */
    public function purchaseOrderForSupplierShouldHaveItems($name, PyStringNode $items)
    {
        foreach ($this->purchaseOrders as $purchaseOrder) {
            if ($purchaseOrder->getSupplier()->getName() == $name) {

                $items = array_map('strtolower', $items->getStrings());
                assertEquals(count($items), $purchaseOrder->getItems()->count(), 'Item count does not match');

                foreach ($purchaseOrder->getItems() as $item) {
                    assertContains(strtolower($item->getName()), $items, 'Item not found');
                }
                break;
            }
        }
    }

    /**
     * @Given I have suppliers:
     */
    public function iHaveSuppliers(PyStringNode $string)
    {
        foreach ($string->getStrings() as $name) {
            $supplier = new Supplier();
            $supplier->setName($name);
            $supplier->setUser(new User());
            $this->suppliers->set($name, $supplier);
        }
    }

    protected function getSupplier($name)
    {
        return $this->suppliers->get($name);
    }

    /**
     * @Given I have a location:
     */
    public function iHaveALocation(PyStringNode $address)
    {

        list($name, $address, $postcode) = $this->parsePyAddress($address);

        $location = new Location();
        $location->setActive(true);
        $location->setName($name);
        $location->setAddress($address);
        $location->setPostcode($postcode);

        $this->location = $location;
    }

    /**
     * @Given the current till location is:
     */
    public function theCurrentTillLocationIs(PyStringNode $address)
    {
        list($name, $address, $postcode) = $this->parsePyAddress($address);

        $location = new Location();
        $location->setActive(true);
        $location->setName($name);
        $location->setAddress($address);
        $location->setPostcode($postcode);

        $this->userLocation = $location;
    }

    /**
     * @Given the supplier address is:
     */
    public function theSupplierAddressIs(PyStringNode $address)
    {
        list($name, $address, $postcode) = $this->parsePyAddress($address);
        $oAddress = new SupplierAddress();
        $oAddress->setCompanyName($name);
        $oAddress->setAddress($address);
        $addressParts = explode("\n", $address, 2);
        $oAddress->setAddress1($addressParts[0]);
        $oAddress->setAddress2($addressParts[1]);
        $oAddress->setPostCode($postcode);
        $oAddress->setPrimaryAddress(true);

        /** @var Supplier $supplier */
        foreach ($this->suppliers as $supplier) {
            if ($supplier->getName() == $oAddress->getCompanyName()) {
                $supplier->getUser()->addAddresses(new ArrayCollection([$oAddress]));
                $this->supplier = $supplier;
                break;
            }
        }
    }

    /**
     * @Then the shipping address should be:
     */
    public function theShippingAddressShouldBe(PyStringNode $pyAddress)
    {
        $address = $this->purchaseOrder->getShippingAddress();
        $address = [
            $address->getAddress(),
            $address->getAddress1(),
            $address->getAddress2(),
            $address->getTown(),
            $address->getPostCode()
        ];
        $address = array_filter($address, function ($line) {
            return $line != '';
        });

        $sAddress = implode("\n", $address);

        assertEquals($pyAddress->getRaw(), $sAddress, 'Shipping Address does not match location address');
    }

    /**
     * @Then the billing address should be:
     */
    public function theBillingAddressShouldBe(PyStringNode $pyAddress)
    {
        $address = $this->purchaseOrder->getBillingAddress();
        $address = [
            $address->getAddress(),
            $address->getAddress1(),
            $address->getAddress2(),
            $address->getTown(),
            $address->getPostCode()
        ];
        $address = array_filter($address, function ($line) {
            return $line != '';
        });

        $sAddress = implode("\n", $address);

        assertEquals($pyAddress->getRaw(), $sAddress, 'Billing Address does not match user location address');
    }

    /**
     * @Then the supplier address should be:
     */
    public function theSupplierAddressShouldBe(PyStringNode $pyAddress)
    {
        $address = $this->purchaseOrder->getSupplierAddress();
        $sAddress = implode("\n", [
                $address->getAddress(),
                $address->getPostCode()
            ]
        );
        assertEquals($pyAddress->getRaw(), $sAddress, 'Supplier Address does not match expected');
    }

    protected function parsePyAddress(PyStringNode $pyString)
    {
        $addr = $pyString->getStrings();
        $name = array_shift($addr);
        $postcode = array_pop($addr);
        $address = implode("\n", $addr);

        return array($name, $address, $postcode);
    }

    /**
     * @Then a message should be shown
     */
    public function aMessageShouldBeShown()
    {
        assertGreaterThanOrEqual(1, count($this->factory->getMessages()), 'Message count is less than expected');
    }

    /**
     * @Then purchase order count should be :count
     */
    public function purchaseOrderCountShouldBe($count)
    {
        assertEquals($count, $this->purchaseOrders->count(), 'Purchase order count does not match expected');
    }
}

<?php

namespace Inventory\Entity\PurchaseOrder;

use Doctrine\Common\Collections\ArrayCollection;
use Inventory\Entity\PurchaseOrder\Address as PurchaseOrderAddress;
use Inventory\Entity\PurchaseOrder\Exception as PurchaseOrderException;

class PurchaseOrder
{
    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var Inventory\Entity\Supplier
     * @ORM\ManyToOne(targetEntity="Inventory\Entity\Supplier")
     * @JMS\Type("Inventory\Entity\Supplier")
     */
    protected $supplier;

    /**
     *
     * @var string
     * @ORM\Column(type="string",nullable=false,length=100)
     */
    protected $supplierName;

    /**
     *
     * @var string
     * @ORM\Column(type="string",nullable=false,length=32)
     */
    protected $supplierReference;

    /**
     *
     * @var string
     * @ORM\Column(type="text",nullable=false)
     */
    protected $terms;

    /**
     *
     * @var string
     * @ORM\Column(type="text",nullable=true)
     */
    protected $remarks;

    /**
     *
     * @var string
     * @ORM\Column(type="string",nullable=true)
     */
    protected $carrier;

    /**
     *
     * @var \DateTime
     * @ORM\Column(type="datetime",nullable=true)
     */
    protected $orderDate;

    /**
     *
     * @var \DateTime
     * @ORM\Column(type="datetime",nullable=true)
     */
    protected $deliveryDate;

    /**
     *
     * @var Inventory\Entity\PurchaseOrder\PaymentMethod
     * @ORM\ManyToOne(targetEntity="Inventory\Entity\PurchaseOrder\PaymentMethod")
     * @JMS\Type("Inventory\Entity\PurchaseOrder\PaymentMethod")
     */
    protected $paymentMethod;

    /**
     *
     * @var Inventory\Entity\PurchaseOrder\Status
     * @ORM\ManyToOne(targetEntity="Inventory\Entity\PurchaseOrder\Status")
     * @JMS\Type("Inventory\Entity\PurchaseOrder\Status")
     */
    protected $status;

    /**
     *
     * @var decimal
     * @ORM\Column(type="decimal", nullable=false, scale=2, precision=9)
     */
    protected $vatCost;

    /**
     *
     * @var decimal
     * @ORM\Column(type="decimal", nullable=false, scale=2, precision=9)
     */
    protected $subtotal;

    /**
     *
     * @var decimal
     * @ORM\Column(type="decimal", nullable=false, scale=2, precision=9)
     */
    protected $totalCost;

    /**
     *
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $modifiedDate;

    /**
     *
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $addDate;

    /**
     *
     * @var Inventory\Entity\PurchaseOrder\Address
     * @ORM\ManyToOne(targetEntity="Inventory\Entity\PurchaseOrder\Address", cascade={"persist","remove"})
     * @JMS\Type("Inventory\Entity\PurchaseOrder\Address")
     */
    protected $supplierAddress;

    /**
     *
     * @var Inventory\Entity\PurchaseOrder\Address
     * @ORM\ManyToOne(targetEntity="Inventory\Entity\PurchaseOrder\Address", cascade={"persist","remove"})
     * @JMS\Type("Inventory\Entity\PurchaseOrder\Address")
     */
    protected $billingAddress;

    /**
     *
     * @var Inventory\Entity\PurchaseOrder\Address
     * @ORM\ManyToOne(targetEntity="Inventory\Entity\PurchaseOrder\Address", cascade={"persist","remove"})
     * @JMS\Type("Inventory\Entity\PurchaseOrder\Address")
     */
    protected $shippingAddress;

    /**
     *
     * @var Inventory\Entity\Location
     * @ORM\ManyToOne(targetEntity="Inventory\Entity\Location")
     * @JMS\Type("Inventory\Entity\Location")
     */
    protected $location;

    /**
     * Items
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Inventory\Entity\PurchaseOrder\Item", mappedBy="parent", cascade={"persist","remove"})
     * @JMS\Type("Inventory\Entity\PurchaseOrder\Item")
     */
    protected $items;

    /**
     * Whether totals have been calculated
     * @var boolean $totalsCalculated
     */
    protected $totalsCalculated;


    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param \Inventory\Entity\Supplier $supplier
     * @return $this
     */
    public function setSupplier(\Inventory\Entity\Supplier $supplier)
    {
        $this->supplier = $supplier;
        return $this;
    }

    /**
     * @return Inventory\Entity\Supplier
     */
    public function getSupplier()
    {
        return $this->supplier;
    }

    /**
     * Set supplierName
     *
     * @param string $supplierName
     * @return PurchaseOrder
     */
    public function setSupplierName($supplierName)
    {
        $this->supplierName = $supplierName;

        return $this;
    }

    /**
     * Get supplierName
     *
     * @return string
     */
    public function getSupplierName()
    {
        return $this->supplierName;
    }

    /**
     * Set supplierReference
     *
     * @param string $supplierReference
     * @return PurchaseOrder
     */
    public function setSupplierReference($supplierReference)
    {
        $this->supplierReference = $supplierReference;

        return $this;
    }

    /**
     * Get supplierReference
     *
     * @return string
     */
    public function getSupplierReference()
    {
        return $this->supplierReference;
    }

    /**
     * Set number
     *
     * @param string $number
     * @return PurchaseOrder
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set terms
     *
     * @param string $terms
     * @return PurchaseOrder
     */
    public function setTerms($terms)
    {
        $this->terms = $terms;

        return $this;
    }

    /**
     * Get terms
     *
     * @return string
     */
    public function getTerms()
    {
        return $this->terms;
    }

    /**
     * Set remarks
     *
     * @param string $remarks
     * @return PurchaseOrder
     */
    public function setRemarks($remarks)
    {
        $this->remarks = $remarks;

        return $this;
    }

    /**
     * Get remarks
     *
     * @return string
     */
    public function getRemarks()
    {
        return $this->remarks;
    }

    /**
     * Set orderDate
     *
     * @param \DateTime $orderDate
     * @return PurchaseOrder
     */
    public function setOrderDate($orderDate)
    {
        $this->orderDate = $orderDate;

        return $this;
    }

    /**
     * Get orderDate
     *
     * @return \DateTime
     */
    public function getOrderDate()
    {
        return $this->orderDate;
    }

    /**
     * Set deliveryDate
     *
     * @param \DateTime $deliveryDate
     * @return PurchaseOrder
     */
    public function setDeliveryDate($deliveryDate)
    {
        $this->deliveryDate = $deliveryDate;

        return $this;
    }

    /**
     * Get deliveryDate
     *
     * @return \DateTime
     */
    public function getDeliveryDate()
    {
        return $this->deliveryDate;
    }

    /**
     * Set vatCost
     *
     * @param string $vatCost
     * @return PurchaseOrder
     */
    public function setVatCost($vatCost)
    {
        $this->vatCost = $vatCost;

        return $this;
    }

    /**
     * Get vatCost
     *
     * @return string
     */
    public function getVatCost()
    {
        return $this->vatCost;
    }

    /**
     * Set subtotal
     *
     * @param string $subtotal
     * @return PurchaseOrder
     */
    public function setSubtotal($subtotal)
    {
        $this->subtotal = $subtotal;

        return $this;
    }

    /**
     * Get subtotal
     *
     * @return string
     */
    public function getSubtotal()
    {
        return $this->subtotal;
    }

    /**
     * Set totalCost
     *
     * @param string $totalCost
     * @return PurchaseOrder
     */
    public function setTotalCost($totalCost)
    {
        $this->totalCost = $totalCost;

        return $this;
    }

    /**
     * Get totalCost
     *
     * @return string
     */
    public function getTotalCost()
    {
        return $this->totalCost;
    }

    /**
     * Set modifiedDate
     *
     * @param \DateTime $modifiedDate
     * @return PurchaseOrder
     */
    public function setModifiedDate($modifiedDate)
    {
        $this->modifiedDate = $modifiedDate;

        return $this;
    }

    /**
     * Get modifiedDate
     *
     * @return \DateTime
     */
    public function getModifiedDate()
    {
        return $this->modifiedDate;
    }

    /**
     * Set addDate
     *
     * @param \DateTime $addDate
     * @return PurchaseOrder
     */
    public function setAddDate($addDate)
    {
        $this->addDate = $addDate;

        return $this;
    }

    /**
     * Get addDate
     *
     * @return \DateTime
     */
    public function getAddDate()
    {
        return $this->addDate;
    }

    /**
     * Set paymentMethod
     *
     * @param \Inventory\Entity\PurchaseOrder\PaymentMethod $paymentMethod
     * @return PurchaseOrder
     */
    public function setPaymentMethod(\Inventory\Entity\PurchaseOrder\PaymentMethod $paymentMethod = null)
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    /**
     * Get paymentMethod
     *
     * @return \Inventory\Entity\PurchaseOrder\PaymentMethod
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * Set status
     *
     * @param Status $status
     * @return PurchaseOrder
     */
    public function setStatus(Status $status = null)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return Status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set supplierAddress
     *
     * @param \Inventory\Entity\PurchaseOrder\Address $supplierAddress
     * @return PurchaseOrder
     */
    public function setSupplierAddress(PurchaseOrderAddress $supplierAddress = null)
    {
        $supplierAddress->setParent($this);
        $this->supplierAddress = $supplierAddress;

        return $this;
    }

    /**
     * Get supplierAddress
     *
     * @return \Inventory\Entity\PurchaseOrder\Address
     */
    public function getSupplierAddress()
    {
        return $this->supplierAddress;
    }

    /**
     * Set billingAddress
     *
     * @param \Inventory\Entity\PurchaseOrder\Address $billingAddress
     * @return PurchaseOrder
     */
    public function setBillingAddress(PurchaseOrderAddress $billingAddress = null)
    {
        $billingAddress->setParent($this);
        $this->billingAddress = $billingAddress;

        return $this;
    }

    /**
     * Get billingAddress
     *
     * @return \Inventory\Entity\PurchaseOrder\Address
     */
    public function getBillingAddress()
    {
        return $this->billingAddress;
    }

    /**
     * Set shippingAddress
     *
     * @param \Inventory\Entity\PurchaseOrder\Address $shippingAddress
     * @return PurchaseOrder
     */
    public function setShippingAddress(PurchaseOrderAddress $shippingAddress = null)
    {
        $shippingAddress->setParent($this);
        $this->shippingAddress = $shippingAddress;

        return $this;
    }

    /**
     * Get shippingAddress
     *
     * @return \Inventory\Entity\PurchaseOrder\Address
     */
    public function getShippingAddress()
    {
        return $this->shippingAddress;
    }

    /**
     * Set location
     *
     * @param \Inventory\Entity\Location $location
     * @return PurchaseOrder
     */
    public function setLocation(\Inventory\Entity\Location $location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return \Inventory\Entity\Location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param string $carrier
     * @return $this
     */
    public function setCarrier($carrier)
    {
        $this->carrier = $carrier;
        return $this;
    }

    /**
     * @return string $carrier
     */
    public function getCarrier()
    {
        return $this->carrier;
    }

    /**
     * @return ArrayCollection
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param mixed array|ArrayCollection $items
     * @return $this
     */
    public function addItems($items)
    {
        foreach ($items as $item) {
            $item->setParent($this);
            $this->items->add($item);
        }
        return $this;
    }

    /**
     * @param mixed array|ArrayCollection $items
     * @return $this
     */
    public function removeItems($items)
    {
        foreach ($items as $item) {
            $item->setParent(null);
            $this->items->removeElement($item);
        }
        return $this;
    }

    public function calculateTotals()
    {
        if (!$this->totalsCalculated) {
            $vatCost = 0;
            $subtotal = 0;
            $totalCost = 0;

            foreach ($this->getItems() as $orderItem) {
                $orderItem->calculateTotals();
                $vatCost += $orderItem->getTaxAmount();
                $subtotal += $orderItem->getRowTotal();
                $totalCost += $orderItem->getRowTotal();
            }

            $this->setVatCost($vatCost)
                ->setSubtotal($subtotal)
                ->setTotalCost($totalCost)
                ->totalsCalculated(true);
        }
        return $this;
    }

    /**
     * @param boolean|null $flag
     * @return bool
     */
    private function totalsCalculated($flag = null)
    {
        if ($flag !== null) {
            $this->totalsCalculated = $flag;
        }
        return $this->totalsCalculated;
    }


    public function isValid()
    {
        if (!isset($this->location)) {
            throw new PurchaseOrderException('Location not set');
        }

        if (!isset($this->supplier)) {
            throw new PurchaseOrderException('Supplier not set');
        }

        return true;
    }
}

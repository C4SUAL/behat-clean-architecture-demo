<?php

namespace Inventory\Entity\PurchaseOrder;

class Item
{
    /**
     *
     * @var integer
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Inventory\DBAL\Generator\Sequence")
     */
    protected $id;

    /**
     *
     * @var string
     * @ORM\Column(type="string", nullable=false, length=50)
     */
    protected $sku;

    /**
     *
     * @var string
     * @ORM\Column(type="string", nullable=false, length=60)
     */
    protected $barcode;

    /**
     *
     * @var string
     * @ORM\Column(type="string", nullable=false, length=150)
     */
    protected $name;

    /**
     *
     * @var integer
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $qty;

    /**
     *
     * @var decimal
     * @ORM\Column(type="decimal", nullable=false, scale=2, precision=9)
     */
    protected $taxrate;

    /**
     *
     * @var decimal
     * @ORM\Column(type="decimal", nullable=false, scale=2, precision=9)
     */
    protected $unitPrice;

    /**
     *
     * @var decimal
     * @ORM\Column(type="decimal", nullable=false, scale=2, precision=9)
     */
    protected $taxAmount;

    /**
     *
     * @var decimal
     * @ORM\Column(type="decimal", nullable=false, scale=2, precision=9)
     */
    protected $rowTotal;

    /**
     *
     * @var Inventory\Entity\PurchaseOrder\PurchaseOrder
     * @ORM\ManyToOne(targetEntity="Inventory\Entity\PurchaseOrder\PurchaseOrder", inversedBy="items")
     * @JMS\Type("Inventory\Entity\PurchaseOrder\PurchaseOrder")
     */
    protected $parent;

    /**
     *
     * @var Inventory\Entity\PurchaseOrder\ItemStatus
     * @ORM\ManyToOne(targetEntity="Inventory\Entity\PurchaseOrder\ItemStatus")
     * @JMS\Type("Inventory\Entity\PurchaseOrder\ItemStatus")
     */
    protected $status;

    /**
     *
     * @var Inventory\Entity\Product
     * @ORM\ManyToOne(targetEntity="Inventory\Entity\Product")
     * @JMS\Type("Inventory\Entity\Product")
     */
    protected $product;

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


    public function __construct() {}

    /**
     * @ORM\PrePersist
     */
    public function prePersist() {
        $this->addDate = $this->modifiedDate = new \DateTime;
        $this->calculateTotals();
    }

    /**
     * @ORM\PreUpdate
     */
    public function beforeUpdate() {
        $this->modifiedDate = new \DateTime;
        $this->calculateTotals();
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    /**
     * Set sku
     *
     * @param string $sku
     * @return Item
     */
    public function setSku($sku)
    {
        $this->sku = $sku;

        return $this;
    }

    /**
     * Get sku
     *
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * Set barcode
     *
     * @param string $barcode
     * @return Item
     */
    public function setBarcode($barcode)
    {
        $this->barcode = $barcode;

        return $this;
    }

    /**
     * Get barcode
     *
     * @return string
     */
    public function getBarcode()
    {
        return $this->barcode;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Item
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set qty
     *
     * @param integer $qty
     * @return Item
     */
    public function setQty($qty)
    {
        $this->qty = $qty;

        return $this;
    }

    /**
     * Get qty
     *
     * @return integer
     */
    public function getQty()
    {
        return $this->qty;
    }

    /**
     * Set taxrate
     *
     * @param string $taxrate
     * @return Item
     */
    public function setTaxrate($taxrate)
    {
        $this->taxrate = $taxrate;

        return $this;
    }

    /**
     * Get taxrate
     *
     * @return string
     */
    public function getTaxrate()
    {
        return $this->taxrate;
    }

    /**
     * Set taxAmount
     *
     * @param string $taxAmount
     * @return Item
     */
    public function setTaxAmount($taxAmount)
    {
        $this->taxAmount = $taxAmount;

        return $this;
    }

    /**
     * Get taxAmount
     *
     * @return string
     */
    public function getTaxAmount()
    {
        return $this->taxAmount;
    }

    /**
     * Set rowTotal
     *
     * @param string $rowTotal
     * @return Item
     */
    public function setRowTotal($rowTotal)
    {
        $this->rowTotal = $rowTotal;

        return $this;
    }

    /**
     * Get rowTotal
     *
     * @return string
     */
    public function getRowTotal()
    {
        return $this->rowTotal;
    }

    /**
     * Set status
     *
     * @param ItemStatus $status
     * @return Item
     */
    public function setStatus(ItemStatus $status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return ItemStatus
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set modifiedDate
     *
     * @param \DateTime $modifiedDate
     * @return Item
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
     * @return Item
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
     * Set parent
     *
     * @param \Inventory\Entity\PurchaseOrder\PurchaseOrder $parent
     * @return Item
     */
    public function setParent(\Inventory\Entity\PurchaseOrder\PurchaseOrder $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Inventory\Entity\PurchaseOrder\PurchaseOrder
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set product
     *
     * @param \Inventory\Entity\Product $product
     * @return Item
     */
    public function setProduct(\Inventory\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \Inventory\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /*
     * @return float $unitPrice
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

    /**
     * @param float $unitPrice
     * @return Item
     */
    public function setUnitPrice($unitPrice)
    {
        if (!is_float($unitPrice) && $unitPrice < 0) {
            throw new \InvalidArgumentException('Unit price must be a decimal greater than or equal to 0');
        }
        $this->unitPrice = $unitPrice;
        return $this;
    }

    public function calculateTax($line = false) {
        // taxrate
        if (!$this->taxrate) {
            $this->taxrate = $this->getProduct->getTaxrate();
        }
        $taxrate = 1 + ($this->taxrate / 100);
        return ($line === true ? $this->qty : 1) * (number_format(($this->getProduct()->getPrice() / $taxrate), 2, '.', ''));
    }

    public function calculateTotals()
    {
        // unitPrice
        $product = $this->getProduct();

        // Debugging
        if ($product === null) {
            \Doctrine\Common\Util\Debug::dump($this);
            throw new \Exception('Product cannot be NULL');
        }
        // /Debugging

        // taxrate
        if (!$this->taxrate) {
            $this->setTaxrate($product->getTaxRate()->getRate());
        }
        // taxAmount
        if (!$this->taxAmount) {
            $this->setTaxAmount($this->calculateTax(true)); // calculate tax for line
        }
        // rowTotal
        $rowTotal = $this->qty * $this->unitPrice;
        $this->setRowTotal($rowTotal);

        return $this;
    }
}

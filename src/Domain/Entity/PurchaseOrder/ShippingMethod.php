<?php

namespace Inventory\Entity\PurchaseOrder;

class ShippingMethod
{
    /**
     *
     * @var integer
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=150, nullable=false)
     */
    protected $name;

    /**
     *
     * @var boolean
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $active;

    /**
     *
     * @var
     * @ORM\ManyToOne(targetEntity="Inventory\Entity\Taxrate")
     */
    protected $taxrate;

    /**
     *
     * @var decimal
     * @ORM\Column(type="decimal", nullable=false, scale=2, precision=9)
     */
    protected $price;


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

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return ShippingMethod
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
     * Set active
     *
     * @param boolean $active
     * @return ShippingMethod
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return ShippingMethod
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set taxrate
     *
     * @param \Inventory\Entity\Taxrate $taxrate
     * @return ShippingMethod
     */
    public function setTaxrate(\Inventory\Entity\Taxrate $taxrate = null)
    {
        $this->taxrate = $taxrate;

        return $this;
    }

    /**
     * Get taxrate
     *
     * @return \Inventory\Entity\Taxrate
     */
    public function getTaxrate()
    {
        return $this->taxrate;
    }

    /**
     * Set modifiedDate
     *
     * @param \DateTime $modifiedDate
     * @return Address
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
     * @return Address
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
}
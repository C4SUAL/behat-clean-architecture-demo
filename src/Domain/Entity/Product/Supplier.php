<?php

namespace Inventory\Entity\Product;

use Inventory\Entity\Product;

class Supplier
{
    /**
     */
    private $id;

    /**
     *
     * @var Product
     */
    protected $product;

    /**
     *
     * @var \Inventory\Entity\Supplier
     */
    protected $supplier;

    /**
     */
    private $cost;

    /**
     */
    private $supplierCode;

    /**
     */
    private $active;

    /**
     */
    private $primarySupplier;

    /**
     */
    private $orderingUom;

    /**
     */
    private $minOrder;

    /**
     */
    private $outerUom;

    /**
     */
    private $modifiedDate;

    /**
     */
    private $addDate;


    /**
     * Get id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set id
     * Used for CloneItem trait
     *
     * @param $id
     * @return Supplier
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set cost
     *
     * @param string $cost
     * @return Supplier
     */
    public function setCost($cost)
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * Get cost
     *
     * @return string
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Set supplierCode
     *
     * @param string $supplierCode
     * @return Supplier
     */
    public function setSupplierCode($supplierCode)
    {
        $this->supplierCode = $supplierCode;

        return $this;
    }

    /**
     * Get supplierCode
     *
     * @return string
     */
    public function getSupplierCode()
    {
        return $this->supplierCode;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Supplier
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
     * Set primarySupplier
     *
     * @param boolean $primarySupplier
     * @return Supplier
     */
    public function setPrimarySupplier($primarySupplier)
    {
        $this->primarySupplier = (bool) $primarySupplier;

        return $this;
    }

    /**
     * Get primarySupplier
     *
     * @return boolean
     */
    public function getPrimarySupplier()
    {
        return $this->primarySupplier;
    }

    /**
     * Set orderingUom
     *
     * @param integer $orderingUom
     * @return Supplier
     */
    public function setOrderingUom($orderingUom)
    {
        $this->orderingUom = $orderingUom;

        return $this;
    }

    /**
     * Get orderingUom
     *
     * @return integer
     */
    public function getOrderingUom()
    {
        return $this->orderingUom;
    }

    /**
     * Set minOrder
     *
     * @param integer $minOrder
     * @return Supplier
     */
    public function setMinOrder($minOrder)
    {
        $this->minOrder = $minOrder;

        return $this;
    }

    /**
     * Get minOrder
     *
     * @return integer
     */
    public function getMinOrder()
    {
        return $this->minOrder;
    }

    /**
     * Set outerUom
     *
     * @param integer $outerUom
     * @return Supplier
     */
    public function setOuterUom($outerUom)
    {
        $this->outerUom = $outerUom;

        return $this;
    }

    /**
     * Get outerUom
     *
     * @return integer
     */
    public function getOuterUom()
    {
        return $this->outerUom;
    }

    /**
     * Set modifiedDate
     *
     * @param \DateTime $modifiedDate
     * @return Supplier
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
     * @return Supplier
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
     * Set product
     *
     * @param \Inventory\Entity\Product $product
     * @return Supplier
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

    /**
     * Set supplier
     *
     * @param \Inventory\Entity\Supplier $supplier
     * @return Supplier
     */
    public function setSupplier(\Inventory\Entity\Supplier $supplier = null)
    {
        $this->supplier = $supplier;

        return $this;
    }

    /**
     * Get supplier
     *
     * @return \Inventory\Entity\Supplier
     */
    public function getSupplier()
    {
        return $this->supplier;
    }

    /**
     * @return bool
     */
    public function isPrimary() {
        return $this->getPrimarySupplier();
    }
}
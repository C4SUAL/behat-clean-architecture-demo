<?php

namespace Inventory\Entity\Location;

use Inventory\Entity\Category;
use Inventory\Entity\Product;
use Inventory\Entity\Location;

class ProductInventory
{
    /**
     * @var integer autoid
     */
    protected $id;

    /**
     * @var Inventory\Entity\Product
     */
    protected $product;

    /**
     * @var Inventory\Entity\Location
     */
    protected $location;

    /**
     * int
     */
    protected $minStockQty;

    /**
     * @var int
     */
    protected $maxStockQty;

    /**
     * @var
     */
    protected $allowBackorders;

    /**
     * @var boolean
     */
    protected $manageStock;

    /**
     * @var
     */
    protected $addDate;

    /**
     * @var
     */
    protected $modifiedDate;


    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getProduct() {
        return $this->product;
    }

    public function setProduct(Product $product = null) {
        $this->product = $product;
        return $this;
    }

    public function getLocation() {
        return $this->location;
    }

    public function setLocation(Location $location = null) {
        $this->location = $location;
        return $this;
    }

    public function getAllowBackorders()
    {
        return $this->allowBackorders;
    }

    public function setAllowBackorders($allowBackorders)
    {
        $this->allowBackorders = (boolean) $allowBackorders;
        return $this;
    }

    public function getManageStock()
    {
        return $this->manageStock;
    }

    public function setManageStock($manageStock)
    {
        $this->manageStock = (boolean) $manageStock;
        return $this;
    }

    public function getMinStockQty()
    {
        return $this->minStockQty;
    }

    public function setMinStockQty($minStockQty)
    {
        if (is_numeric($minStockQty)) {
            settype($minStockQty, 'integer');
        }
        if (!(is_int($minStockQty) || is_null($minStockQty))) {
            throw new \InvalidArgumentException('Value must be numeric or NULL');
        }

        $this->minStockQty = $minStockQty;
        return $this;
    }

    public function getMaxStockQty()
    {
        return $this->maxStockQty;
    }

    public function setMaxStockQty($maxStockQty)
    {
        if (is_numeric($maxStockQty)) {
            settype($maxStockQty, 'integer');
        }
        if (!(is_int($maxStockQty) || is_null($maxStockQty))) {
            throw new \InvalidArgumentException('Value must be numeric or NULL');
        }

        $this->maxStockQty = $maxStockQty;
        return $this;
    }

    public function getAddDate() {
        return $this->addDate;
    }

    public function getModifiedDate() {
        return $this->modifiedDate;
    }

    public function setAddDate($addDate) {
        $this->addDate = $addDate;
    }

    public function setModifiedDate($modifiedDate) {
        $this->modifiedDate = $modifiedDate;
    }
}

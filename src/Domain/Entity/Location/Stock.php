<?php

namespace Inventory\Entity\Location;

use Doctrine\Common\Collections\ArrayCollection;
use Inventory\Entity\Location;
use Inventory\Entity\Product;

class Stock
{
    /**
     * @var integer autoid
     */
    protected $id;

    /**
     *
     * @var Inventory\Entity\Product
     */
    protected $product;

    /**
     *
     * @var Inventory\Entity\Location
     */
    protected $location;

    /**
     *
     * @var integer
     */
    protected $quantity;

    /**
     *
     * @var
     */
    protected $costValue;

    /**
     *
     * @var datetime
     */
    protected $addDate;

    /**
     *
     * @var datetime
     */
    protected $modifiedDate;

    /**
     * @var
     */
    protected $logs;
    
    /**
     *
     * @var 
     */
    protected $invoiceReference;


    public function __construct() {
        $this->logs = new ArrayCollection();
    }
    
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
    }

    public function getLocation() {
        return $this->location;
    }

    public function setLocation(Location $location = null) {
        $this->location = $location;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function getAddDate() {
        return $this->addDate;
    }

    public function getModifiedDate() {
        return $this->modifiedDate;
    }

    public function getCostValue() {
        return $this->costValue;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }

    public function setAddDate($addDate) {
        $this->addDate = $addDate;
    }

    public function setModifiedDate($modifiedDate) {
        $this->modifiedDate = $modifiedDate;
    }

    public function setCostValue($costValue) {
        $this->costValue = $costValue;
    }
    
    public function getInvoiceReference() {
        return $this->invoiceReference;
    }
    public function setInvoiceReference($invoiceReference) {
        $this->invoiceReference = $invoiceReference;
    }
    
    public function getLogs() {
        return $this->logs;
    }

    public function addLogs($logs) {
        foreach ($logs as $log) {
            $log->setStock($this);
            $this->logs->add($log);
        }
    }

    public function removeLogs($logs) {
        foreach ($logs as $log) {
            $log->setStock(null);
            $this->logs->removeElement($log);
        }
    }
}

<?php

namespace Inventory\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Inventory\Entity\Brand;

class Location {

    /**
     * @var integer autoid
     */
    protected $id;

    /**
     * @var Inventory\Entity\Location
     */
    protected $children;

    /**
     * @var Inventory\Entity\Location
     */
    protected $parent;

    /**
     * @var Inventory\Entity\Location\Stock
     */
    protected $stock;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var text
     */
    protected $address;

    /**
     * @var string
     */
    protected $postcode;

    /**
     * @var float
     */
    protected $geo_lat;

    /**
     * @var float
     */
    protected $geo_lon;

    /**
     * @var integer
     */
    protected $position;

    /**
     * @var float
     */
    protected $service;

    /**
     * @var boolean
     */
    protected $active;

    /**
     * @var datetime
     */
    protected $addDate;

    /**
     * @var string
     */
    protected $reference;

    /**
     * @var datetime
     */
    protected $modifiedDate;

    /**
     * @var float
     */
    protected $budget;

    /**
     * @var ArrayCollection
     */
    protected $productInventory;


    public function __construct() {
        $this->children = new ArrayCollection();
        $this->stock = new ArrayCollection();
    }

    public function getId() {
        return $this->id;
    }

    public function getParent() {
        return $this->parent;
    }

    public function getChildren() {
        return $this->children;
    }

    public function getName() {
        return $this->name;
    }

    public function getAddress() {
        return $this->address;
    }

    public function getPostcode() {
        return $this->postcode;
    }

    public function getGeo_lat() {
        return $this->geo_lat;
    }

    public function getGeo_lon() {
        return $this->geo_lon;
    }

    public function getPosition() {
        return $this->position;
    }

    public function getService() {
        return $this->service;
    }

    public function getReference() {
        return $this->reference;
    }

    public function getActive() {
        return $this->active;
    }

    public function getAddDate() {
        return $this->addDate;
    }

    public function getModifiedDate() {
        return $this->modifiedDate;
    }

    public function getBudget() {
        return $this->budget;
    }
	
    public function setId($id) {
        $this->id = $id;
    }

    public function setParent(Location $parent = null) {
        $this->parent = $parent;
    }

    public function addChildren($children) {
        foreach ($children as $child) {
            $child->setProduct($this);
            $this->children->add($child);
        }
    }

    public function removeChildren($children) {
        foreach ($children as $child) {
            $child->setParent(null);
            $this->children->remvoeEntity($child);
        }
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

    public function setPostcode($postcode) {
        $this->postcode = $postcode;
    }

    public function setGeo_lat($geo_lat) {
        $this->geo_lat = $geo_lat;
    }

    public function setGeo_lon($geo_lon) {
        $this->geo_lon = $geo_lon;
    }

    public function setPosition($position) {
        $this->position = $position;
    }

    public function setService($service) {
        $this->service = $service;
    }

    public function setReference($reference) {
        $this->reference = $reference;
    }

    public function setActive($active) {
        $this->active = $active;
    }

    public function setAddDate($addDate) {
        $this->addDate = $addDate;
    }

    public function setBudget($budget) {
        $this->budget = $budget;
    }
	
    public function setModifiedDate($modifiedDate) {
        $this->modifiedDate = $modifiedDate;
    }

    public function getStock() {
        return $this->stock;
    }

    public function addStock($stockList) {
        foreach ($stockList as $stock) {
            $stock->setLocation($this);
            $this->stock->add($stock);
        }
    }

    public function removeStock($stockList) {
        foreach ($stockList as $stock) {
            $stock->setLocation(null);
            $this->stock->removeElement($stock);
        }
    }

    /**
     * Return all product inventory items
     *
     * @return ArrayCollection $productInventory
     */
    public function getProductInventory()
    {
        return $this->productInventory;
    }

    /**
     * Add product inventory entities
     *
     * @param \Traversable $inventory
     * @return $this
     */
    public function addProductInventory(\Traversable $inventory) {
        foreach ($inventory as $productInventory) {
            $productInventory->setLocation($this);
            $this->productInventory->add($productInventory);
        }
        return $this;
    }

    /**
     * Remove product inventory entities
     *
     * @param \Traversable $inventory
     * @return $this
     */
    public function removeProductInventory(\Traversable $inventory) {
        foreach ($inventory as $productInventory){
            $productInventory->setLocation(null);
            $this->productInventory->remove($productInventory);
        }
        return $this;
    }

}

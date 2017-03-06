<?php

namespace Inventory\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Product {

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $ean;

    /**
     * @var string
     */
    protected $sku;

    /**
     * @var decimal
     */
    protected $rrp;

    /**
     * @var decimal
     */
    protected $price;

    /**
     * @var integer
     */
    protected $points;

    /**
     * @var integer
     */
    protected $stock;

    /**
     * @var boolean
     */
    protected $active;

    /**
     * @var datetime
     */
    protected $addDate;

    /**
     * @var datetime
     */
    protected $modifiedDate;

    /**
     * @var string
     */
    protected $recieptName;

    /**
     * @var int
     */
    protected $ageLimit;

    /**
     * @var
     */
    protected $description;

    /**
     * @var Inventory\Entity\Product\Option
     */
    protected $options;

    /**
     * @var Inventory\Entity\Product\Image
     */
    protected $images;

    /**
     * @var Inventory\Entity\Category\Product
     */
    protected $categories;

    /**
     * @var Inventory\Entity\Brand
     */
    protected $brand;

    /**
     * @var Inventory\Entity\Product\Item
     */
    protected $items;

    /**
     * @var
     */
    protected $stockLevels;

    /**
     * @var
     */
    protected $attributes;

    /**
     * @var
     */
    protected $departments;

    /**
     * @var Inventory\Entity\ProductGroup\Product
     */
    protected $groups;

    /**
     * @var
     */
    protected $taxrate;

    /**
     * @var boolean
     */
    protected $serviceChargable;

    /**
     * @var
     */
    protected $serviceCharge;

    /**
     * @var Inventory\Entity\Product\Code
     */
    protected $codes;

    /**
     */
    protected $stockReduction;

    /**
     */
    protected $baseUom;

    /**
     * @var ArrayCollection
     */
    protected $suppliers;

    /**
     * @var ArrayCollection
     */
    protected $locationInventory;


    public function __construct() {
        $this->categories = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->options = new ArrayCollection();
        $this->items = new ArrayCollection();
        $this->attributes = new ArrayCollection();
        $this->departments = new ArrayCollection();
        $this->groups = new ArrayCollection();
        $this->codes = new ArrayCollection();
        $this->suppliers = new ArrayCollection();
        $this->locationInventory = new ArrayCollection();
        $this->stockLevels = new ArrayCollection();
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getEan() {
        return $this->ean;
    }

    public function setEan($ean) {
        $this->ean = $ean;
    }

    public function getSku() {
        return $this->sku;
    }

    public function setSku($sku) {
        $this->sku = $sku;
    }

    public function getRrp() {
        return $this->rrp;
    }

    public function setRrp($rrp) {
        $this->rrp = $rrp;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function getPoints() {
        return $this->points;
    }

    public function setPoints($points) {
        $this->points = $points;
    }

    public function getActive() {
        return $this->active;
    }

    public function getRecieptName() {
        return $this->recieptName;
    }

    public function setActive($active) {
        $this->active = $active;
    }

    public function getAddDate() {
        return $this->addDate;
    }

    public function setAddDate($addDate) {
        $this->addDate = $addDate;
    }

    public function getModifiedDate() {
        return $this->modifiedDate;
    }

    public function setModifiedDate($modifiedDate) {
        $this->modifiedDate = $modifiedDate;
    }

    public function getOptions() {
        return $this->options;
    }
    
    public function getActiveOptions() {
        $options = $this->getOptions();
        $return = array();
        if(count($options) > 0) {
            foreach($options as $option) {
                if($option->getActive() === true) {
                    $return[] = $option;
                }
            }
        }
        return $return;
    }

    public function addOptions($options) {
        foreach ($options as $option) {
            $option->setProduct($this);
            $this->options->add($option);
        }
    }

    public function removeOptions($options) {
        foreach ($options as $option) {
            $option->setProduct(null);
            $this->options->removeElement($option);
        }
    }

    public function getStock() {
        return $this->stock;
    }

    public function setStock($stock) {
        $this->stock = $stock;
    }

    public function removeStock($stock) {
        foreach ($stock as $item) {
            $item->setProduct(null);
            $this->stock->removeElement($item);
        }
    }

    public function getImages() {
        return $this->images;
    }

    public function addImages($images) {
        foreach ($images as $image) {
            $image->setProduct($this);
            $this->images->add($image);
        }
    }

    public function removeImages($images) {
        foreach ($images as $image) {
            $image->setProduct(null);
            $this->images->removeElement($image);
        }
    }

    public function getCategories() {
        return $this->categories;
    }

    public function addCategories($categories) {
        foreach ($categories as $category) {
            $category->setProduct($this);
            $this->categories->add($category);
        }
    }

    public function removeCategories($categories) {
        foreach ($categories as $category) {
            $category->setProduct(null);
            $category->setCategory(null);
            $this->categories->removeElement($category);
        }
    }

    public function getBrand() {
        return $this->brand;
    }

    public function setBrand(Brand $brand = null) {
        $this->brand = $brand;
    }

    public function setRecieptName($recieptName) {
        $this->recieptName = $recieptName;
    }

    public function getItems() {
        return $this->items;
    }

    public function addItems($items) {
        foreach ($items as $item) {
            $item->setParentProduct($this);
            $this->items->add($item);
        }
    }

    public function removeItems($items) {
        foreach ($items as $item) {
            $item->setParentProduct(null);
            $this->items->removeElement($item);
        }
    }

    public function getAgeLimit() {
        return $this->ageLimit;
    }

    public function setAgeLimit($age) {
        $this->ageLimit = $age;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getStockLevels() {
        return $this->stockLevels;
    }

    public function addStockLevels($levels) {
        foreach ($levels as $level) {
            $level->setProduct($this);
            $this->stockLevels->add($level);
        }
    }

    public function removeStockLevels($levels) {
        foreach ($levels as $level) {
            $level->setProduct(null);
            $this->stockLevels->removeElement($level);
        }
    }

    public function getAttributes() {
        return $this->attributes;
    }

    public function addAttributes($attributes) {
        foreach ($attributes as $attribute) {
            $attribute->setProduct($this);
            $this->attributes->add($attribute);
        }
    }

    public function removeAttributes($attributes) {
        foreach ($attributes as $attribute) {
            $attribute->setProduct(null);
            $this->attributes->removeElement($attribute);
        }
    }

    public function getDepartments() {
        return $this->departments;
    }

    public function addDepartments($departments) {
        foreach ($departments as $department) {
            $department->setProduct($this);
            $this->departments->add($department);
        }
    }

    public function removeDepartments($departments) {
        foreach ($departments as $department) {
            $department->setProduct(null);
            $this->departments->removeElement($department);
        }
    }

    public function getGroups() {
        return $this->groups;
    }

    public function addGroups($groups) {
        foreach ($groups as $group) {
            $group->setProduct($this);
            $this->groups->add($group);
        }
    }

    public function removeGroups($groups) {
        foreach ($groups as $group) {
            $group->setProduct(null);
            $this->groups->removeElement($group);
        }
    }

    public function getCodes() {
        return $this->codes;
    }

    public function addCodes($codes) {
        foreach ($codes as $code) {
            $code->setProduct($this);
            $this->codes->add($code);
        }
    }

    public function removeCodes($codes) {
        foreach ($codes as $code) {
            $code->setProduct(null);
            $this->codes->removeElement($code);
        }
    }

    public function getTaxrate() {
        return $this->taxrate;
    }

    public function setTaxrate($taxrate = null) {
        $this->taxrate = $taxrate;
    }

    public function getServiceChargable() {
        return $this->serviceChargable;
    }

    public function getServiceCharge() {
        return $this->serviceCharge;
    }

    public function setServiceChargable($serviceChargable) {
        $this->serviceChargable = $serviceChargable;
    }

    public function setServiceCharge($serviceCharge) {
        $this->serviceCharge = $serviceCharge;
    }

    public function getStockReduction() {
        return $this->stockReduction;
    }

    public function setStockReduction($reduction) {
        $this->stockReduction = $reduction;
    }

    public function displayItems() {
        $return = array();
        if (count($this->getItems()) > 0) {
            foreach ($this->getItems() as $item) {
                $return[] = array(
                    $item->getProduct()->getName(),
                    $item->getProduct()->displayItems(),
                    $item->getQuantity(),
                );
            }
        }
        return $return;
    }

    public function getFlatCategories() {
        $return = array();
        if (count($this->getCategories()) > 0) {
            foreach ($this->getCategories() as $category) {
                $return[] = $category->getId();
            }
        }
        return $return;
    }

    public function flatCategoryIds($toParent = false) {
        $return = array();
        if (count($this->getCategories()) > 0) {
            foreach ($this->getCategories() as $category) {
                $return[] = $category->getCategory()->getId();
                if ($toParent === true) {
                    $details = $category->getCategory()->toParent(array());
                    if ($details !== array()) {
                        for ($i = 0; $i < count($details); $i++) {
                            if (!in_array($details[$i][0], $return)) {
                                $return[] = $details[$i][0];
                            }
                        }
                    }
                }
            }
        }
        return $return;
    }

    public function recieptName() {
        if (trim($this->recieptName) == '') {
            return strlen($this->name) > 19 ? substr($this->name, 0, 19) : $this->name;
        } else {
            return $this->recieptName;
        }
    }

    public function canDisplayOn($displayType = 'all') {
        $displayOn = array('all');
        if (count($this->categories) > 0) {
            for ($i = 0; $i < count($this->categories); $i++) {
                if (!in_array($this->categories[$i]->getCategory()->getDisplayOn(), $displayOn)) {
                    $displayOn[] = $this->categories[$i]->getCategory()->getDisplayOn();
                }
            }
        }
        return in_array($displayType, $displayOn);
    }

    public function hasCategory($categoryId = null) {
        if ($categoryId === null) {
            return null;
        } else {
            return in_array($categoryId, $this->getFlatCategories());
        }
    }

    public function inCategory($category = null) {
        $inCat = false;
        if (count($this->categories) > 0) {
            for ($i = 0; $i < count($this->categories); $i++) {
                $inCat = !is_array($category) ? ($this->categories[$i]->getCategory()->getId() == $category ? true : $inCat) : (in_array($this->categories[$i]->getCategory()->getId(), $category) ? true : $inCat);
            }
        }
        return $inCat;
    }

    public function getAttribute($name = '') {
        $value = null;
        if ($name !== '' && count($this->attributes) > 0) {
            for ($i = 0; $i < count($this->attributes); $i++) {
                if ($this->attributes[$i]->getAttribute()->getName() == $name) {
                    $value = $this->attributes[$i]->getValue();
                }
            }
        }
        return $value;
    }

    public function getAttrById($id = null) {
        if ($id === null) {
            return null;
        } else {
            //id is being passed as the whole attribute from somewhere and this breaks things
            //check and if it is an instance of Inventory\Entity\Attribute
            //change it to be the id
            if (($id instanceof \Inventory\Entity\Attribute)) {
                $id = $id->getId();
            }
            $this->getAttributes();
            if (count($this->attributes) > 0) {
                for ($i = 0; $i < count($this->attributes); $i++) {
                    if ($this->attributes[$i]->getAttribute()->getId() == $id) {
                        return $this->attributes[$i]->getValue();
                    }
                }
            }
        }
    }

    public function getClassification() {
        $type = 'food';
        $this->getCategories();
        if (count($this->categories) > 0) {
            for ($i = 0; $i < count($this->categories); $i++) {
                $this->categories[$i]->getCategory();
                $current = $this->categories[$i]->getCategory()->getFoodPrint();
                $type = ($this->categories[$i]->getCategory()->getFoodPrint() == false) ? 'drink' : $type;
            }
        }
        return $type;
    }
    
    public function inDepartment($department = '') {
        $inDepartment = false;
        if(count($this->departments) > 0) {
            for($i=0;$i<count($this->departments);$i++) {
                $inDepartment = $this->departments[$i]->getDepartment()->getName() == $department ? true : $inDepartment;
            }
        }
        return $inDepartment;
    }
    
    public function inProductGroup($productGroup = '') {
        $inGroup = false;
        if(count($this->groups) > 0) {
            for($i=0;$i<count($this->groups);$i++) {
                $inGroup = $this->groups[$i]->getProductGroup()->getName() == $productGroup ? true : $inGroup;
            }
        }
        return $inGroup;
    }

    /**
     * Set baseUom (Standard Stock Unit)
     *
     * @param integer $baseUom
     * @return Supplier
     */
    public function setBaseUom($baseUom)
    {
        if (is_numeric($baseUom)) {
            settype($baseUom, 'integer');
        } else {
            throw new \InvalidArgumentException('Value must be an integer');
        }
        $this->baseUom = $baseUom;

        return $this;
    }

    /**
     * Get baseUom (Standard Stock Unit)
     *
     * @return integer
     */
    public function getBaseUom()
    {
        return $this->baseUom;
    }

    /**
     * @return ArrayCollection $suppliers
     */
    public function getSuppliers() {
        return $this->suppliers;
    }

    public function getSupplier(Supplier $supplier)
    {
        return $this->getSuppliers()->filter(function($item) use ($supplier) {
            return ($item->getSupplier()->getId() == $supplier->getId());
        })->first();
    }

    /**
     * @param array|ArrayCollection $suppliers collection Inventory\Entity\Product\Suppliers
     */
    public function addSuppliers($suppliers) {
        foreach ($suppliers as $supplier) {
            $supplier->setProduct($this);
            $this->suppliers->add($supplier);
        }
    }

    /**
     * @param array|ArrayCollection $suppliers collection of Inventory\Entity\Product\Suppliers
     */
    public function removeSuppliers($suppliers) {
        foreach ($suppliers as $supplier) {
            $supplier->setProduct(null);
            $this->suppliers->removeElement($supplier);
        }
    }

    /**
     * Return all location inventory items or single using $key
     * @param integer $key offset
     *
     * @return mixed ArrayCollection|Location\ProductInventory|null
     */
    public function getLocationInventory($key = null)
    {
        if (is_int($key)) {
            return $this->locationInventory->get($key);
        } else {
            return $this->locationInventory;
        }
    }

    /**
     * Add location inventory entities
     *
     * @param mixed array|ArrayCollection $inventory
     * @return $this
     */
    public function addLocationInventory($inventory) {
        foreach ($inventory as $locationInventory) {
            $locationInventory->setProduct($this);
            $this->locationInventory->add($locationInventory);
        }
        return $this;
    }

    /**
     * Remove location inventory entities
     *
     * @param mixed array|ArrayCollection $inventory
     * @return $this
     */
    public function removeLocationInventory($inventory) {
        foreach ($inventory as $locationInventory){
            $locationInventory->setProduct(null);
            $this->locationInventory->removeElement($locationInventory);
        }
        return $this;
    }

    /**
     * Return the primary supplier for a Product, or the first if only one
     *
     * @return Inventory\Entity\Product\Supplier $primary product supplier
     */
    public function getPrimarySupplier() {
        if ($this->suppliers->count() > 1) {
            $primaryCol = $this->suppliers->filter(function($item) {
                return $item->isPrimary();
            });
            $primary = $primaryCol->first();
        } else {
            $primary = $this->suppliers->first();
        }
        return $primary;
    }

    /**
     * Get ProductInventory matching location
     *
     * @param Location $location
     * @return mixed|null
     */
    public function getInventoryForLocation(Location $location) {
        return $this->getLocationInventory()->filter(function($item) use ($location) {
            return ($item->getLocation() == $location);
        })->first();
    }
}

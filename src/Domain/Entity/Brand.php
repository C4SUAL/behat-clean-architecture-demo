<?php

namespace Inventory\Entity;


class Brand {

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var text
     */
    protected $description;

    /**
     * @var text
     */
    protected $longDescription;

    /**
     * @var boolean
     */
    protected $active;

    /**
     * @var boolean
     */
    protected $showPrices;

    /**
     * @var boolean
     */
    protected $sellProductsOnline;

    /**
     * @var \DateTime
     */
    protected $addDate;

    /**
     * @var \DateTime
     */
    protected $modifiedDate;


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

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getLongDescription() {
        return $this->longDescription;
    }

    public function setLongDescription($longDescription) {
        $this->longDescription = $longDescription;
    }

    public function getActive() {
        return $this->active;
    }

    public function setActive($active) {
        $this->active = $active;
    }

    public function getShowPrices() {
        return $this->showPrices;
    }

    public function setShowPrices($showPrices) {
        $this->showPrices = $showPrices;
    }

    public function getSellProductsOnline() {
        return $this->sellProductsOnline;
    }

    public function setSellProductsOnline($sellProductsOnline) {
        $this->sellProductsOnline = $sellProductsOnline;
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

}

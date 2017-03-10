<?php

namespace Inventory\Entity;

class Taxrate
{

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var float
     */
    protected $rate;

    /**
     * @var boolean
     */
    protected $active;

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

    public function getName() {
        return $this->name;
    }

    public function getRate() {
        return $this->rate;
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

    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setRate($rate) {
        $this->rate = $rate;
    }

    public function setActive($active) {
        $this->active = $active;
    }

    public function setAddDate($addDate) {
        $this->addDate = $addDate;
    }

    public function setModifiedDate($modifiedDate) {
        $this->modifiedDate = $modifiedDate;
    }
}

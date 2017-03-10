<?php

namespace Inventory\Entity\Country;

use Inventory\Entity\Country;

class County
{
    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var string
     * @ORM\Column(type="string",length=150,nullable=false)
     */
    protected $name;

    /**
     *
     * @var Country
     * @ORM\ManyToOne(targetEntity="Inventory\Entity\Country",inversedBy="counties",cascade={"persist","remove"})
     * @JMS\Type("Inventory\Entity\Country")
     */
    protected $country;
    
    /**
     *
     * @var \DateTime
     * @ORM\Column(type="datetime",nullable=false)
     */
    protected $addDate;
    
    /**
     *
     * @var \DateTime
     * @ORM\Column(type="datetime",nullable=false)
     */
    protected $modifiedDate;

    public function __clone() {
        if ($this->id) {
            $this->setId(null);
        }
    }
    
    /**
     * @ORM\PrePersist
     */
    public function prePersist() {
        if(!($this->addDate instanceof \DateTime)) {
            $this->addDate = new \DateTime();
        }
        $this->modifiedDate = new \DateTime();
    }
    
    /**
     * @ORM\PreUpdate
     */
    public function preUpdate() {
        $this->modifiedDate = new \DateTime();
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

    public function getCountry() {
        return $this->country;
    }

    public function setCountry(Country $country = null) {
        $this->country = $country;
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

<?php

namespace Inventory\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Country
{
    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var string
     * @ORM\Column(type="string",length=150,nullable=false);
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="Inventory\Entity\Country\County",mappedBy="country",cascade={"persist","remove"})
     * @JMS\Type("ArrayCollection<Inventory\Entity\Country\County>")
     * @JMS\ReadOnly
     * @JMS\Accessor(getter="getCounties",setter="addCounties")
     */
    protected $counties;
    
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

    public function __construct() {
        $this->counties = new ArrayCollection();
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

    public function getCounties() {
        return $this->counties;
    }

    public function addCounties($counties) {
        foreach ($counties as $county) {
            $county->setCountry($this);
            $this->counties->add($county);
        }
    }

    public function removeCounties($counties) {
        foreach ($counties as $county) {
            $county->setCountry(null);
            $this->counties->removeElement($county);
        }
    }

}

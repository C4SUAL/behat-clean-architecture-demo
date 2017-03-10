<?php

namespace Inventory\Entity\User;

use Inventory\Entity\User;
use Inventory\Entity\Country;
use Inventory\Entity\Country\County;

class Address
{
    /**
     *
     * @var integer $id
     */
    protected $id;

    /**
     *
     * @var string
     * @ORM\Column(type="string",length=20,nullable=false)
     */
    protected $type;

    /**
     *
     * @var string
     * @ORM\Column(type="string",length=150,nullable=true)
     */
    protected $companyName;

    /**
     *
     * @var string
     * @ORM\Column(type="string",length=150,nullable=false)
     */
    protected $address;

    /**
     *
     * @var string
     * @ORM\Column(type="string",length=150,nullable=true)
     */
    protected $address1;

    /**
     *
     * @var string
     * @ORM\Column(type="string",length=150,nullable=true)
     */
    protected $address2;

    /**
     *
     * @var string
     * @ORM\Column(type="string",length=150,nullable=false)
     */
    protected $town;

    /**
     *
     * @var string
     * @ORM\Column(type="string",length=15,nullable=false)
     */
    protected $postCode;

    /**
     *
     * @var Boolean
     * @ORM\Column(type="boolean")
     */
    protected $primaryAddress;

    /**
     *
     * @var \DateTime
     * @ORM\Column(type="datetime",nullable=false)
     */
    protected $modifiedDate;

    /**
     *
     * @var \DateTime
     * @ORM\Column(type="datetime",nullable=false)
     */
    protected $addDate;

    /**
     *
     * @var User
     * @ORM\ManyToOne(targetEntity="Inventory\Entity\User",inversedBy="addresses",cascade={"persist","remove"})
     * @JMS\Type("Inventory\Entity\User")
     */
    protected $user;

    /**
     *
     * @var County
     * @ORM\ManyToOne(targetEntity="Inventory\Entity\Country\County",cascade={"persist","remove"})
     * @JMS\Type("Inventory\Entity\Country\County")
     */
    protected $county;

    /**
     *
     * @var Country
     * @ORM\ManyToOne(targetEntity="Inventory\Entity\Country",cascade={"persist","remove"})
     * @JMS\Type("Inventory\Entity\Country")
     */
    protected $country;

    /**
     * @ORM\PrePersist
     */
    public function prePersist() {
        if (!($this->addDate instanceof \DateTime)) {
            $this->setAddDate(new \DateTime());
        }
        $this->setModifiedDate(new \DateTime());
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate() {
        $this->setModifiedDate(new \DateTime());
    }

    //<editor-fold desc="Getters/Setters" defaultstate="collapsed">
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function getCompanyName() {
        return $this->companyName;
    }

    public function setCompanyName($companyName) {
        $this->companyName = $companyName;
    }

    public function getAddress() {
        return $this->address;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

    public function getAddress1() {
        return $this->address1;
    }

    public function setAddress1($address1) {
        $this->address1 = $address1;
    }

    public function getAddress2() {
        return $this->address2;
    }

    public function setAddress2($address2) {
        $this->address2 = $address2;
    }

    public function getTown() {
        return $this->town;
    }

    public function setTown($town) {
        $this->town = $town;
    }

    public function getPostCode() {
        return $this->postCode;
    }

    public function setPostCode($postCode) {
        $this->postCode = $postCode;
    }

    public function getPrimaryAddress() {
        return $this->primaryAddress;
    }

    public function setPrimaryAddress($primaryAddress) {
        $this->primaryAddress = $primaryAddress;
    }

    public function getModifiedDate() {
        return $this->modifiedDate;
    }

    public function setModifiedDate($modifyDate) {
        $this->modifiedDate = $modifyDate;
    }

    public function getAddDate() {
        return $this->addDate;
    }

    public function setAddDate($addDate) {
        $this->addDate = $addDate;
    }

    public function getUser() {
        return $this->user;
    }

    public function setUser(User $user = null) {
        $this->user = $user;
    }

    public function getCounty() {
        return $this->county;
    }

    public function setCounty(County $county = null) {
        $this->county = $county;
    }

    public function getCountry() {
        return $this->country;
    }

    public function setCountry(Country $country = null) {
        $this->country = $country;
    }

//</editor-fold>

    public function render() { //TODO: refactor
        $address1 = $this->address;
        $address2 = $this->address1;
        $address3 = $this->address2;
        $town = $this->town !== NULL ? $this->town : "";
        $county = $this->county !== NULL ? $this->county->getName() : "";
        $country = $this->country !== NULL ? $this->country->getName() : "";
        $postcode = $this->postCode;
        if (strlen($address1) > 0)
            $address1 .= "<br />";
        if (strlen($address2) > 0)
            $address2 .= "<br />";
        if (strlen($address3) > 0)
            $address3 .= "<br />";
        if (isset($town))
            $town .= "<br />";
        if (isset($county))
            $county .= "<br />";
        if (isset($country))
            $country .= "<br />";
        return $address1 . $address2 . $address3 . $town . $county . $country . $postcode;
    }
    
    public function getName() {
        return trim($this->companyName . " " . $this->address);
    }

}

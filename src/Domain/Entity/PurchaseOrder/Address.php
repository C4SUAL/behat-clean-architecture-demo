<?php

namespace Inventory\Entity\PurchaseOrder;

class Address
{
    /**
     *
     * @var integer
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Inventory\DBAL\Generator\Sequence")
     */
    protected $id;

    /**
     *
     * @var string
     * @ORM\Column(type="string", nullable=false, length=20)
     */
    protected $addressType;

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
     *
     * @var string
     * @ORM\Column(type="string", length=55, nullable=true)
     */
    protected $title;

    /**
     *
     * @var string
     * @ORM\Column(type="string", length=60, nullable=true)
     */
    protected $firstName;

    /**
     *
     * @var string
     * @ORM\Column(type="string", length=60, nullable=true)
     */
    protected $lastName;

    /**
     *
     * @var string
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    protected $companyName;

    /**
     *
     * @var Inventory\Entity\PurchaseOrder\PurchaseOrder
     * @ORM\ManyToOne(targetEntity="Inventory\Entity\PurchaseOrder\PurchaseOrder",  cascade={"persist"})
     * @JMS\Type("Inventory\Entity\PurchaseOrder\PurchaseOrder")
     */
    protected $parent;

    /**
     *
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $modifiedDate;

    /**
     *
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $addDate;


    public function __construct(AddressType $type = null)
    {
        if ($type !== null)
        {
            $this->setAddressType($type);
        }
    }


    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    /**
     * Set addressType
     *
     * @param string $addressType
     * @return Address
     */
    public function setAddressType($addressType)
    {
        $this->addressType = $addressType;

        return $this;
    }

    /**
     * Get addressType
     *
     * @return string
     */
    public function getAddressType()
    {
        return $this->addressType;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Address
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set address1
     *
     * @param string $address1
     * @return Address
     */
    public function setAddress1($address1)
    {
        $this->address1 = $address1;

        return $this;
    }

    /**
     * Get address1
     *
     * @return string
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * Set address2
     *
     * @param string $address2
     * @return Address
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;

        return $this;
    }

    /**
     * Get address2
     *
     * @return string
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * Set town
     *
     * @param string $town
     * @return Address
     */
    public function setTown($town)
    {
        $this->town = $town;

        return $this;
    }

    /**
     * Get town
     *
     * @return string
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * Set postCode
     *
     * @param string $postCode
     * @return Address
     */
    public function setPostCode($postCode)
    {
        $this->postCode = $postCode;

        return $this;
    }

    /**
     * Get postCode
     *
     * @return string
     */
    public function getPostCode()
    {
        return $this->postCode;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Address
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return Address
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return Address
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set companyName
     *
     * @param string $companyName
     * @return Address
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;

        return $this;
    }

    /**
     * Get companyName
     *
     * @return string
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * Set modifiedDate
     *
     * @param \DateTime $modifiedDate
     * @return Address
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
     * @return Address
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
     * Set county
     *
     * @param \Inventory\Entity\Country\County $county
     * @return Address
     */
    public function setCounty(\Inventory\Entity\Country\County $county = null)
    {
        $this->county = $county;

        return $this;
    }

    /**
     * Get county
     *
     * @return \Inventory\Entity\Country\County
     */
    public function getCounty()
    {
        return $this->county;
    }

    /**
     * Set country
     *
     * @param \Inventory\Entity\Country $country
     * @return Address
     */
    public function setCountry(\Inventory\Entity\Country $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return \Inventory\Entity\Country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set parent
     *
     * @param \Inventory\Entity\PurchaseOrder\PurchaseOrder $parent
     * @return Address
     */
    public function setParent(\Inventory\Entity\PurchaseOrder\PurchaseOrder $parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Inventory\Entity\PurchaseOrder\PurchaseOrder
     */
    public function getParent()
    {
        return $this->parent;
    }

}

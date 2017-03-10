<?php

namespace Inventory\Entity\PurchaseOrder;

class PaymentMethod
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
     * @var string
     * @ORM\Column(type="string", length=150, nullable=false)
     */
    protected $name;

    /**
     *
     * @var boolean
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $active;

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

    /**
     * @ORM\PrePersist
     */
    public function prePersist() {
        if (!($this->addDate instanceof \DateTime)) {
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

    /**
     * Set name
     *
     * @param string $name
     * @return ShippingMethod
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return ShippingMethod
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
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
}
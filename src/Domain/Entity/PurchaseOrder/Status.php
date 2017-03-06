<?php

namespace Inventory\Entity\PurchaseOrder;

class Status
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

    public function setId($id) {
        $this->id = $id;
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
}
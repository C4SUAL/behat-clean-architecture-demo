<?php

namespace Inventory\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Supplier
{
    private $id;

    private $reference;

    private $name;

    private $terms;

    private $remarks;

    private $creditLimit;

    /**
     * @var User
     */
    private $user;

    /**
     * @var \Inventory\Entity\Product\Supplier[]
     */
    protected $products;

    /**
     * @var \DateTime
     */
    protected $addDate;

    /**
     * @var \DateTime
     */
    protected $modifiedDate;


    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * Set reference
     *
     * @param string $reference
     * @return Supplier
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Supplier
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
     * Set terms
     *
     * @param string $terms
     * @return Supplier
     */
    public function setTerms($terms)
    {
        $this->terms = $terms;

        return $this;
    }

    /**
     * Get terms
     *
     * @return string
     */
    public function getTerms()
    {
        return $this->terms;
    }

    /**
     * Set remarks
     *
     * @param string $remarks
     * @return Supplier
     */
    public function setRemarks($remarks)
    {
        $this->remarks = $remarks;

        return $this;
    }

    /**
     * Get remarks
     *
     * @return string
     */
    public function getRemarks()
    {
        return $this->remarks;
    }

    /**
     * Set creditLimit
     *
     * @param string $creditLimit
     * @return Supplier
     */
    public function setCreditLimit($creditLimit)
    {
        $this->creditLimit = $creditLimit;

        return $this;
    }

    /**
     * Get creditLimit
     *
     * @return string
     */
    public function getCreditLimit()
    {
        return $this->creditLimit;
    }

    /**
     * Set user
     *
     * @param \Inventory\Entity\User $user
     * @return Supplier
     */
    public function setUser(\Inventory\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Inventory\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    public function getAddDate()
    {
        return $this->addDate;
    }

    public function setAddDate($date)
    {
        if (!$date instanceof \DateTime) {
            throw new \InvalidArgumentException('$date must be an instance of \DateTime');
        }
        $this->addDate = $date;
        return $this;
    }

    public function getModifiedDate()
    {
        return $this->modifiedDate;
    }

    public function setModifiedDate($date)
    {
        if (!$date instanceof \DateTime) {
            throw new \InvalidArgumentException('$date must be an instance of \DateTime');
        }
        $this->modifiedDate = $date;
        return $this;
    }

    public function getProducts() {
        return $this->products;
    }

    /**
     * @param \Inventory\Entity\Product\Supplier[] $productSuppliers
     */
    public function addProducts($productSuppliers) {
        foreach ($productSuppliers as $productSupplier) {
            $productSupplier->setSupplier($this);
            $this->products->add($productSupplier);
        }
    }

    /**
     * @param \Inventory\Entity\Product\Supplier[] $productSuppliers
     */
    public function removeProducts($productSuppliers) {
        foreach ($productSuppliers as $productSupplier) {
            $productSupplier->setSupplier(null);
            $this->products->removeElement($productSupplier);
        }
    }
}
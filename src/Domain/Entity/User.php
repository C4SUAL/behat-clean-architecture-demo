<?php

namespace Inventory\Entity;

use Inventory\Entity\User\Address;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class User 
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     */
    protected $type;

    /**
     */
    protected $title;

    /**
     * @var string
     */
    protected $firstName;

    /**
     * @var string
     */
    protected $lastName;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var \DateTime
     */
    protected $lastLoginDate;

    /**
     * @var \DateTime
     */
    protected $modifiedDate;

    /**
     * @var \DateTime
     */
    protected $registerDate;

    /**
     * @var bool
     */
    protected $active;

    /**
     * @var string
     */
    protected $tillPassword;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $emails;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $phones;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $addresses;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $roles;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $openIds;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $attributes;

    /**
     * @var
     */
    protected $profileImagePath;
    
    /**
     * @var string
     */
    protected $loginToken;

    /**
     */
    protected $supplier;


    /**
     * User object constructor
     */
    public function __construct() {
        $this->emails = new ArrayCollection();
        $this->phones = new ArrayCollection();
        $this->addresses = new ArrayCollection();
        $this->roles = new ArrayCollection();
        $this->openIds = new ArrayCollection();
        $this->attributes = new ArrayCollection();
    }

    /**
     * Check Password matches entity password
     * @var string $password
     * @return boolean
     */
    public function passwordCheck($password) {
        //add encryption stuff here
        return $password == $this->password ? TRUE : FALSE;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title = null) {
        $this->title = $title;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function setLastName($lastName) {
        $this->lastName = $lastName;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getLastLoginDate() {
        return $this->lastLoginDate;
    }

    public function setLastLoginDate($lastLoginDate) {
        $this->lastLoginDate = $lastLoginDate;
    }

    public function getModifiedDate() {
        return $this->modifiedDate;
    }

    public function setModifiedDate($modifiedDate) {
        $this->modifiedDate = $modifiedDate;
    }

    public function getRegisterDate() {
        return $this->registerDate;
    }

    public function setRegisterDate($registerDate) {
        $this->registerDate = $registerDate;
    }

    public function getActive() {
        return $this->active;
    }

    public function setActive($active) {
        $this->active = $active;
    }

    public function getEmails() {
        return $this->emails;
    }

    public function addEmails($emails) {
        foreach ($emails as $email) {
            $email->setUser($this);
            $this->emails->add($email);
        }
    }

    public function removeEmails($emails) {
        foreach ($emails as $email) {
            $email->setUser(null);
            $this->emails->removeElement($email);
        }
    }
    
    
    public function getFirstEMailAddress() {
        $emails = $this->getEmails();
        if (isset($emails[0])) {
            $email = $emails[0];
        }
        if (isset($email)) {
            return $email->getEmail();
        }
    }

    public function getPhones() {
        return $this->phones;
    }

    public function addPhones(Collection $phones) {
        foreach ($phones as $phone) {
            $phone->setUser($this);
            $this->phones->add($phone);
        }
    }

    public function removePhones(Collection $phones) {
        foreach ($phones as $phone) {
            $phone->setUser(null);
            $this->phones->removeElement($phone);
        }
    }

    public function getFirstPhone() {
        $phones = $this->getPhones();
        if (isset($phones[0])) {
            $phone = $phones[0];
        }
        if (isset($phone)) {
            return $phone->getPhone();
        } else {
            return "Unknown";
        }
    }

    public function getAddresses() {
        return $this->addresses;
    }

    public function addAddresses(Collection $addresses) {
        foreach ($addresses as $address) {
            $address->setUser($this);
            $this->addresses->add($address);
        }
    }

    public function removeAddresses(Collection $addresses) {
        foreach ($addresses as $address) {
            $address->setUser(null);
            $this->addresses->removeElement($address);
        }
    }

    public function getFirstCompanyName() {
        $addresses = $this->getAddresses();
        if (isset($addresses[0])) {
            $address = $addresses[0];
        }
        if (isset($address)) {
            return $address->getCompanyName();
        }
    }

    public function getFirstAddress() {
        $addresses = $this->getAddresses();
        if (isset($addresses[0])) {
            $address = $addresses[0];
        }
        if (isset($address)) {
            $address1 = $address->getAddress();
            $address2 = $address->getAddress1();
            $address3 = $address->getAddress2();
            $town = $address->getTown() !== NULL ? $address->getTown() : "";
            $county = $address->getCounty() !== NULL ? $address->getCounty()->getName() : "";
            $country = $address->getCountry() !== NULL ? $address->getCountry()->getName() : "";
            $postcode = $address->getPostCode();
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
        } else {
            return "Unknown";
        }
    }

    public function getDeliveryAddress() {
        $addresses = $this->getAddresses();
        if (count($addresses) > 0) {
            for ($i = 0; $i < count($addresses); $i++) {
                if ($addresses[$i]->getType() == "Delivery" && $addresses[$i]->getPrimaryAddress()) {
                    $address = $addresses[$i];
                }
            }
        }

        if (isset($address)) {
            $address1 = $address->getAddress();
            $address2 = $address->getAddress1();
            $address3 = $address->getAddress2();
            $town = $address->getTown() !== NULL ? $address->getTown() : "";
            $county = $address->getCounty() !== NULL ? $address->getCounty()->getName() : "";
            $country = $address->getCountry() !== NULL ? $address->getCountry()->getName() : "";
            $postcode = $address->getPostCode();
            $company = $address->getCompanyName() !== NULL ? $address->getCompanyName() : "";
            if (strlen($company) > 0)
                $company .= "<br />";
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
            return $company . $address1 . $address2 . $address3 . $town . $county . $country . $postcode;
        } else {
            return "Unknown";
        }
    }

    /**
     * Get the (first) primary address [matching $type]
     *
     * @var string type
     * @return Address|null
     */
    public function getPrimaryAddress($type = null) {
        return $this->addresses->filter(function($address) use ($type) {
            if ($type) {
                if (strtolower($type) != strtolower($address->getType()))  {
                    return false;
                }
            }
            return $address->getPrimaryAddress();
        })->first();
    }

    /**
     * Add a Role
     *
     * @var \Inventory\Entity\User\Role $role
     * @return User
     */
    public function addRole(\Inventory\Entity\User\Role $role)
    {
        $role->setUser($this);
        $this->roles->add($role);
        return $this;
    }

    /**
     * Remove a Role
     *
     * @var \Inventory\Entity\User\Role $roles
     */
    public function removeRole(\Inventory\Entity\User\Role $roles)
    {
        $roles->setUser($this);
        $this->roles->removeElement($roles);
    }

    public function getRoles() {
        return $this->roles;
    }


    public function getAllRolesAsString() {
		$allRoles = "";
        $roles = $this->getRoles();
		foreach($roles as $role) {
			if (isset($role)) {
				$allRoles .= $role->getName() . ",";
			}
		}
		$allRoles = rtrim($allRoles, ",");
		if (strlen($allRoles == 0)) $allRoles = "None";
		return $allRoles;
    }
	
    public function addRoles(Collection $roles) {
        foreach ($roles as $role) {
            $role->setUser($this);
            $this->roles->add($role);
        }
    }

    public function removeRoles(Collection $roles) {
        foreach ($roles as $role) {
            $role->setUser(null);
            $this->roles->removeElement($role);
        }
    }

    public function getOpenIds() {
        return $this->openIds;
    }

    public function addOpenIds(Collection $openIds) {
        foreach ($openIds as $openId) {
            $openId->setUser($this);
            $this->openIds->add($openId);
        }
    }

    public function removeOpenIds(Collection $openIds) {
        foreach ($openIds as $openId) {
            $openId->setUser(null);
            $this->openIds->removeElement($openId);
        }
    }

    public function __toString() {
        return $this->getName();
    }

    public function getName() {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function getTillPassword() {
        return $this->tillPassword;
    }

    public function setTillPassword($password) {
        $this->tillPassword = $password;
    }

    public function getAttributes() {
        return $this->attributes;
    }

    public function addAttributes(Collection $attributes) {
        foreach ($attributes as $attribute) {
            $attribute->setUser($this);
            $this->attributes->add($attribute);
        }
    }

    public function removeAttributes(Collection $attributes) {
        foreach ($attributes as $attribute) {
            $attribute->setUser(null);
            $this->attributes->removeElement($attribute);
        }
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type = null) {
        $this->type = $type;
    }

    public function getProfileImagePath() {
        return $this->profileImagePath;
    }

    public function setProfileImagePath($profileImagePath = null) {
        $this->profileImagePath = $profileImagePath;
    }
    
    public function getLoginToken() {
        return $this->loginToken;
    }
    
    public function setLoginToken($token = '') {
        $this->loginToken = $token;
    }

    public function getAttributeValue($attribute = null) {
        if ($attribute === null) {
            return null;
        } else {
            $attributes = $this->getAttributes();
            if (count($attributes) > 0) {
                for ($i = 0; $i < count($attributes); $i++) {
                    if ($attributes[$i]->getAttribute()->getName() === $attribute) {
                        return $attributes[$i]->getValue();
                    }
                }
            }
            return null;
        }
    }

    public function hasRole($check = array()) {
        $hasRole = false;
        if (count($this->roles) > 0) {
            for ($i = 0; $i < count($this->roles); $i++) {
                $name = $this->roles[$i]->getRole()->getName();
                if (is_array($check) ? in_array($name, $check) : $name == $check) {
                    $hasRole = true;
                }
            }
        }
        return $hasRole;
    }

    public function hasAddress($check) {
        $hasAddress = false;
        if (count($this->addresses) > 0) {
            for ($i = 0; $i < count($this->addresses); $i++) {
                $addressId = $this->addresses[$i]->getId();
                $hasAddress = $addressId == $check ? true : $hasAddress;
            }
        }
        return $hasAddress;
    }
    
    public function hasEmail($check = '') {
        $hasItem = false;
        if(trim($check) != '') {
            if(count($this->emails) > 0) {
                for($i=0;$i<count($this->emails);$i++) {
                    if($hasItem == true) {
                        break; //quick escape if we are in user with a lot of emails return as early as possible
                    } else {
                        $hasItem = $this->emails[$i]->getEmailAddress() == $check ? true : $hasItem;
                    }
                }
            }
        }
        return $hasItem;
    }

    public function getSupplier()
    {
        return $this->supplier;
    }

    public function setSupplier(Supplier $supplier)
    {
        $this->supplier = $supplier;
        return $this;
    }
}

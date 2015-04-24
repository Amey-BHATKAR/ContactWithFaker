<?php

namespace Adipsys\testBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Address
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Address
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="blockNumber", type="integer")
     */
    private $blockNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="streetName", type="string", length=255)
     */
    private $streetName;

    /**
     * @var integer
     *
     * @ORM\Column(name="zipCode", type="integer")
     */
    private $zipCode;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=50)
     */
    private $country;

    
    
    /**
     * @ORM\ManyToOne(targetEntity="Contact", inversedBy="addresses")
     * @ORM\JoinColumn(name="contact_id", referencedColumnName="id")
     **/
    private $contact;

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
     * Set blockNumber
     *
     * @param integer $blockNumber
     * @return Address
     */
    public function setBlockNumber($blockNumber)
    {
        $this->blockNumber = $blockNumber;

        return $this;
    }

    /**
     * Get blockNumber
     *
     * @return integer 
     */
    public function getBlockNumber()
    {
        return $this->blockNumber;
    }

    /**
     * Set streetName
     *
     * @param string $streetName
     * @return Address
     */
    public function setStreetName($streetName)
    {
        $this->streetName = $streetName;

        return $this;
    }

    /**
     * Get streetName
     *
     * @return string 
     */
    public function getStreetName()
    {
        return $this->streetName;
    }

    /**
     * Set zipCode
     *
     * @param integer $zipCode
     * @return Address
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * Get zipCode
     *
     * @return integer 
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return Address
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set contact
     *
     * @param \Adipsys\testBundle\Entity\Contact $contact
     * @return Address
     */
    public function setContact(\Adipsys\testBundle\Entity\Contact $contact = null)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact
     *
     * @return \Adipsys\testBundle\Entity\Contact 
     */
    public function getContact()
    {
        return $this->contact;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->contact = new Contact();
    }

    /**
     * Add contact
     *
     * @param \Adipsys\testBundle\Entity\Contact $contact
     * @return Address
     */
    public function addContact(\Adipsys\testBundle\Entity\Contact $contact)
    {
        $this->contact[] = $contact;

        return $this;
    }

    /**
     * Remove contact
     *
     * @param \Adipsys\testBundle\Entity\Contact $contact
     */
    public function removeContact(\Adipsys\testBundle\Entity\Contact $contact)
    {
        $this->contact->removeElement($contact);
    }
    
    public function __toString()
    {
    	$sendString = $this->blockNumber.", ".$this->streetName.", ".$this->zipCode.", ".$this->country;
    	return $sendString;
    }
}

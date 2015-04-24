<?php

namespace Adipsys\testBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Contact
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Adipsys\testBundle\Entity\ContactRepository")
 */
class Contact
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
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=100)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=100)
     */
    private $lastName;


    
    /**
     * @ORM\OneToMany(targetEntity="Address", mappedBy = "contact")
    **/
    private $addresses;
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
    	$this->addresses = new ArrayCollection();
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
     * Set firstName
     *
     * @param string $firstName
     * @return Contact
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
     * @return Contact
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
     * Add addresses
     *
     * @param \Adipsys\testBundle\Entity\Address $addresses
     * @return Contact
     */
    public function addAddresses(\Adipsys\testBundle\Entity\Address $addresses)
    {
        $this->addresses[]= $addresses;

        return $this;
    }

    /**
     * Remove address
     *
     * @param \Adipsys\testBundle\Entity\Address $addresses
     */
    public function removeAddress(\Adipsys\testBundle\Entity\Address $addresses)
    {
        $this->addresses->removeElement($addresses);
    }

    /**
     * Get addresses
     *
     * @return \Adipsys\testBundle\Entity\Address $addresses
     */
    public function getAddresses()
    {
    	return $this->addresses;
    }
    
 	public function __toString()
    {
    	$sendString = $this->firstName.", ".$this->lastName;
    	return $sendString;
    }

    /**
     * Add addresses
     *
     * @param \Adipsys\testBundle\Entity\Address $addresses
     * @return Contact
     */
    public function addAddress(\Adipsys\testBundle\Entity\Address $addresses)
    {
        $this->addresses[] = $addresses;

        return $this;
    }
}

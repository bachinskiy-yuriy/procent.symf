<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contact
 *
 * @ORM\Table(name="contact", indexes={@ORM\Index(name="companyid", columns={"companyid"})})
 * @ORM\Entity
 */
class Contact
{
    /**
     * @var string
     *
     * @ORM\Column(name="key", type="string", length=50, nullable=false)
     */
    private $key;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=100, nullable=false)
     */
    private $value;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Proposition
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Proposition", inversedBy="contacts")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="companyid", referencedColumnName="id")
     * })
     */
    private $companyid;



    /**
     * Set key
     *
     * @param string $key
     *
     * @return Contact
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Get key
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set value
     *
     * @param string $value
     *
     * @return Contact
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
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
     * Set companyid
     *
     * @param \AppBundle\Entity\Proposition $companyid
     *
     * @return Contact
     */
    public function setCompanyid(\AppBundle\Entity\Proposition $companyid = null)
    {
        $this->companyid = $companyid;

        return $this;
    }

    /**
     * Get companyid
     *
     * @return \AppBundle\Entity\Proposition
     */
    public function getCompanyid()
    {
        return $this->companyid;
    }
    
    public function __toString()
    {
        return "nothing";
    }

}

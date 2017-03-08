<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
// use Symfony\Component\Validator\Constraints as Assert;

/**
 * Subscriber
 *
 * @ORM\Table(name="subscriber", uniqueConstraints={@ORM\UniqueConstraint(name="mail", columns={"mail"})})
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\subscriberRepository")
 */
class Subscriber
{
    /**
     * @var string
     *
     * @ORM\Column(name="user", type="string", length=50, nullable=false)
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=50, nullable=false)
     */
    private $mail;

    /**
     * @var string
     *
     * @ORM\Column(name="tel", type="string", length=20, nullable=true)
    */
    private $tel;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="subscribedate", type="datetime", nullable=true)
     */
    private $subscribedate = 'CURRENT_TIMESTAMP';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

	public function __construct()
    {
        $this->subscribedate = new \DateTime();
    }

    /**
     * Set user
     *
     * @param string $user
     *
     * @return Subscriber
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set mail
     *
     * @param string $mail
     *
     * @return Subscriber
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set tel
     *
     * @param string $tel
     *
     * @return Subscriber
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel
     *
     * @return string
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set subscribedate
     *
     * @param \DateTime $subscribedate
     *
     * @return Subscriber
     */
    public function setSubscribedate($subscribedate)
    {
        $this->subscribedate = $subscribedate;

        return $this;
    }

    /**
     * Get subscribedate
     *
     * @return \DateTime
     */
    public function getSubscribedate()
    {
        return $this->subscribedate;
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
}

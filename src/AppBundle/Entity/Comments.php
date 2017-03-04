<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comments
 *
 * @ORM\Table(name="comments", indexes={@ORM\Index(name="companyid", columns={"companyid"})})
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\commentsRepository")
 */
class Comments
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
     * @var integer
     *
     * @ORM\Column(name="rank", type="integer", nullable=true)
     */
    private $rank;

    /**
     * @var string
     *
     * @ORM\Column(name="msg", type="string", length=2000, nullable=false)
     */
    private $msg;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="publdate", type="datetime", nullable=true)
     */
    private $publdate;

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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Proposition", inversedBy="comments")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="companyid", referencedColumnName="id")
     * })
     */
    private $companyid;



    /**
     * Set user
     *
     * @param string $user
     *
     * @return Comments
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
     * @return Comments
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
     * Set rank
     *
     * @param integer $rank
     *
     * @return Comments
     */
    public function setRank($rank)
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * Get rank
     *
     * @return integer
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Set msg
     *
     * @param string $msg
     *
     * @return Comments
     */
    public function setMsg($msg)
    {
        $this->msg = $msg;

        return $this;
    }

    /**
     * Get msg
     *
     * @return string
     */
    public function getMsg()
    {
        return $this->msg;
    }

    /**
     * Set publdate
     *
     * @param \DateTime $publdate
     *
     * @return Comments
     */
    public function setPubldate($publdate)
    {
        $this->publdate = $publdate;

        return $this;
    }

    /**
     * Get publdate
     *
     * @return \DateTime
     */
    public function getPubldate()
    {
        return $this->publdate;
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
     * @return Comments
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
}

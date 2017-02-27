<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * About
 *
 * @ORM\Table(name="about", indexes={@ORM\Index(name="companyid", columns={"companyid"})})
 * @ORM\Entity
 */
class About
{
    /**
     * @var string
     *
     * @ORM\Column(name="article", type="string", length=4000, nullable=false)
     */
    private $article;

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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Proposition")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="companyid", referencedColumnName="id")
     * })
     */
    private $companyid;



    /**
     * Set article
     *
     * @param string $article
     *
     * @return About
     */
    public function setArticle($article)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return string
     */
    public function getArticle()
    {
        return $this->article;
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
     * @return About
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

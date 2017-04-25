<?php

namespace AppBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Translatable;

/**
 * About
 *
 * @ORM\Table(name="about", indexes={@ORM\Index(name="companyid", columns={"companyid"})})
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\aboutRepository")
 */
class About
{
    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="article", type="text", length=65535, nullable=false)
     */
    private $article;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="title", type="string", length=100, nullable=false)
     */
    private $title;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="meta", type="string", length=400, nullable=false)
     */
    private $meta;

    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Proposition
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Proposition", inversedBy="about")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="companyid", referencedColumnName="id")
     * })
     */
    private $companyid;


    /**
     * @Gedmo\Locale
     * Используется для переопределения локали Translation слушателя
     * это простое свойство класса и не отображает поле в базе данных
     * определять это свойство не обязательно, поскольку оно будет автоматически
     * установлено Translation слушателем
     */
    private $locale;

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
     * Set title
     *
     * @param string $title
     *
     * @return About
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set meta
     *
     * @param string $meta
     *
     * @return About
     */
    public function setMeta($meta)
    {
        $this->meta = $meta;

        return $this;
    }

    /**
     * Get meta
     *
     * @return string
     */
    public function getMeta()
    {
        return $this->meta;
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

    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }
}

<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Form\Type\VichFileType;

/**
 * Proposition
 *
 * @ORM\Table(name="proposition")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\propositionRepository")
 * @Vich\Uploadable
 */
class Proposition
{

    public $commision;    
    
    /**
     * @var string
     *
     * @ORM\Column(name="company", type="string", length=50, nullable=false)
     */
    private $company;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=30, nullable=false)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="site", type="string", length=50, nullable=false)
     */
    private $site;

    /**
     * @var string
     *
     * @ORM\Column(name="landing", type="string", length=100, nullable=false)
     */
    private $landing;

    /**
     * @var integer
     *
     * @ORM\Column(name="daymin", type="integer", nullable=false)
     */
    private $daymin;

    /**
     * @var integer
     *
     * @ORM\Column(name="summin", type="integer", nullable=false)
     */
    private $summin;

    /**
     * @var integer
     *
     * @ORM\Column(name="first_daymax", type="integer", nullable=false)
     */
    private $firstDaymax;

    /**
     * @var integer
     *
     * @ORM\Column(name="first_summax", type="integer", nullable=false)
     */
    private $firstSummax;

    /**
     * @var float
     *
     * @ORM\Column(name="first_percent", type="float", precision=10, scale=0, nullable=false)
     */
    private $firstPercent;

    /**
     * @var float
     *
     * @ORM\Column(name="first_discount", type="float", precision=10, scale=0, nullable=false)
     */
    private $firstDiscount;

    /**
     * @var integer
     *
     * @ORM\Column(name="next_daymax", type="integer", nullable=false)
     */
    private $nextDaymax;

    /**
     * @var integer
     *
     * @ORM\Column(name="next_summax", type="integer", nullable=false)
     */
    private $nextSummax;

    /**
     * @var float
     *
     * @ORM\Column(name="next_percent", type="float", precision=10, scale=0, nullable=false)
     */
    private $nextPercent;

    /**
     * @var float
     *
     * @ORM\Column(name="commision1", type="float", precision=10, scale=0, nullable=false)
     */
    private $commision1 = '0';

    /**
     * @var float
     *
     * @ORM\Column(name="commision2", type="float", precision=10, scale=0, nullable=false)
     */
    private $commision2 = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="roundtype", type="integer", nullable=false)
     */
    private $roundtype = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="img", type="string", length=50, nullable=false)
     */
    private $img;

    /**
     * @Vich\UploadableField(mapping="product_image", fileNameProperty="img")
     * 
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $updatedat;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="recomended", type="integer", nullable=false)
     */
    private $recomended = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
    * @ORM\OneToMany(targetEntity="About", mappedBy="companyid")
    */
    protected $about;
	
    /**
    * @ORM\OneToMany(targetEntity="Contact", mappedBy="companyid", cascade={"persist"})
    */
    protected $contacts;

    /**
    * @ORM\OneToMany(targetEntity="Comments", mappedBy="companyid", cascade={"persist"})
    * @ORM\OrderBy({"publdate" = "DESC"})
    */    
    protected $comments;
	
	public function __construct()
    {
        $this->contacts = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->about = new ArrayCollection();
    }

    /**
     * Set company
     *
     * @param string $company
     *
     * @return Proposition
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set site
     *
     * @param string $site
     *
     * @return Proposition
     */
    public function setSite($site)
    {
        $this->site = $site;

        return $this;
    }

    /**
     * Get site
     *
     * @return string
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * Set landing
     *
     * @param string $landing
     *
     * @return Proposition
     */
    public function setLanding($landing)
    {
        $this->landing = $landing;

        return $this;
    }

    /**
     * Get landing
     *
     * @return string
     */
    public function getLanding()
    {
        return $this->landing;
    }

    /**
     * Set daymin
     *
     * @param integer $daymin
     *
     * @return Proposition
     */
    public function setDaymin($daymin)
    {
        $this->daymin = $daymin;

        return $this;
    }

    /**
     * Get daymin
     *
     * @return integer
     */
    public function getDaymin()
    {
        return $this->daymin;
    }

    /**
     * Set summin
     *
     * @param integer $summin
     *
     * @return Proposition
     */
    public function setSummin($summin)
    {
        $this->summin = $summin;

        return $this;
    }

    /**
     * Get summin
     *
     * @return integer
     */
    public function getSummin()
    {
        return $this->summin;
    }

    /**
     * Set firstDaymax
     *
     * @param integer $firstDaymax
     *
     * @return Proposition
     */
    public function setFirstDaymax($firstDaymax)
    {
        $this->firstDaymax = $firstDaymax;

        return $this;
    }

    /**
     * Get firstDaymax
     *
     * @return integer
     */
    public function getFirstDaymax()
    {
        return $this->firstDaymax;
    }

    /**
     * Set firstSummax
     *
     * @param integer $firstSummax
     *
     * @return Proposition
     */
    public function setFirstSummax($firstSummax)
    {
        $this->firstSummax = $firstSummax;

        return $this;
    }

    /**
     * Get firstSummax
     *
     * @return integer
     */
    public function getFirstSummax()
    {
        return $this->firstSummax;
    }

    /**
     * Set firstPercent
     *
     * @param float $firstPercent
     *
     * @return Proposition
     */
    public function setFirstPercent($firstPercent)
    {
        $this->firstPercent = $firstPercent;

        return $this;
    }

    /**
     * Get firstPercent
     *
     * @return float
     */
    public function getFirstPercent()
    {
        return $this->firstPercent;
    }

    /**
     * Set firstDiscount
     *
     * @param float $firstDiscount
     *
     * @return Proposition
     */
    public function setFirstDiscount($firstDiscount)
    {
        $this->firstDiscount = $firstDiscount;

        return $this;
    }

    /**
     * Get firstDiscount
     *
     * @return float
     */
    public function getFirstDiscount()
    {
        return $this->firstDiscount;
    }

    /**
     * Set nextDaymax
     *
     * @param integer $nextDaymax
     *
     * @return Proposition
     */
    public function setNextDaymax($nextDaymax)
    {
        $this->nextDaymax = $nextDaymax;

        return $this;
    }

    /**
     * Get nextDaymax
     *
     * @return integer
     */
    public function getNextDaymax()
    {
        return $this->nextDaymax;
    }

    /**
     * Set nextSummax
     *
     * @param integer $nextSummax
     *
     * @return Proposition
     */
    public function setNextSummax($nextSummax)
    {
        $this->nextSummax = $nextSummax;

        return $this;
    }

    /**
     * Get nextSummax
     *
     * @return integer
     */
    public function getNextSummax()
    {
        return $this->nextSummax;
    }

    /**
     * Set nextPercent
     *
     * @param float $nextPercent
     *
     * @return Proposition
     */
    public function setNextPercent($nextPercent)
    {
        $this->nextPercent = $nextPercent;

        return $this;
    }

    /**
     * Get nextPercent
     *
     * @return float
     */
    public function getNextPercent()
    {
        return $this->nextPercent;
    }

    /**
     * Set commision1
     *
     * @param float $commision1
     *
     * @return Proposition
     */
    public function setCommision1($commision1)
    {
        $this->commision1 = $commision1;

        return $this;
    }

    /**
     * Get commision1
     *
     * @return float
     */
    public function getCommision1()
    {
        return $this->commision1;
    }

    /**
     * Set commision2
     *
     * @param float $commision2
     *
     * @return Proposition
     */
    public function setCommision2($commision2)
    {
        $this->commision2 = $commision2;

        return $this;
    }

    /**
     * Get commision2
     *
     * @return float
     */
    public function getCommision2()
    {
        return $this->commision2;
    }

    /**
     * Set roundtype
     *
     * @param integer $roundtype
     *
     * @return Proposition
     */
    public function setRoundtype($roundtype)
    {
        $this->roundtype = $roundtype;

        return $this;
    }

    /**
     * Get roundtype
     *
     * @return integer
     */
    public function getRoundtype()
    {
        return $this->roundtype;
    }

    /**
     * Set img
     *
     * @param string $img
     *
     * @return Proposition
     */
    public function setImg($img)
    {
        $this->img = $img;

        return $this;
    }

    /**
     * Get img
     *
     * @return string|null
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * Set recomended
     *
     * @param integer $recomended
     *
     * @return Proposition
     */
    public function setRecomended($recomended)
    {
        $this->recomended = $recomended;

        return $this;
    }

    /**
     * Get recomended
     *
     * @return integer
     */
    public function getRecomended()
    {
        return $this->recomended;
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
     * Set about
     *
     * @param \AppBundle\Entity\About $about
     *
     * @return Proposition
     */
    public function setAbout(\AppBundle\Entity\About $about = null)
    {
        $this->about = $about;

        return $this;
    }

    /**
     * Get about
     *
     * @return \AppBundle\Entity\About
     */
    public function getAbout()
    {
        return $this->about;
    }
    
        /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Proposition
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }


    /**
     * Add contact
     *
     * @param \AppBundle\Entity\Contact $contact
     *
     * @return Proposition
     */
    public function addContacts(\AppBundle\Entity\Contact $contact)
    {
        $this->contacts[] = $contact;

        return $this;
    }

    /**
     * Remove contact
     *
     * @param \AppBundle\Entity\Contact $contact
     */
    public function removeContacts(\AppBundle\Entity\Contact $contact)
    {
        $this->contacts->removeElement($contact);
    }

    /**
     * Get contact
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * Add comment
     *
     * @param \AppBundle\Entity\Comments $comment
     *
     * @return Proposition
     */
    public function addComment(\AppBundle\Entity\Comments $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param \AppBundle\Entity\Comments $comment
     */
    public function removeComment(\AppBundle\Entity\Comments $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Add about
     *
     * @param \AppBundle\Entity\About $about
     *
     * @return Proposition
     */
    public function addAbout(\AppBundle\Entity\About $about)
    {
        $this->about[] = $about;

        return $this;
    }

    /**
     * Remove about
     *
     * @param \AppBundle\Entity\About $about
     */
    public function removeAbout(\AppBundle\Entity\About $about)
    {
        $this->about->removeElement($about);
    }

    /**
     * Add contact
     *
     * @param \AppBundle\Entity\Contact $contact
     *
     * @return Proposition
     */
    public function addContact(\AppBundle\Entity\Contact $contact)
    {
        $this->contacts[] = $contact;

        return $this;
    }

    /**
     * Remove contact
     *
     * @param \AppBundle\Entity\Contact $contact
     */
    public function removeContact(\AppBundle\Entity\Contact $contact)
    {
        $this->contacts->removeElement($contact);
    }
    
    public function getCommentsCount()
    {
        $cnt = 0;
        foreach ($this->comments as $entry) {
            $cnt += 1;
        }
        return $cnt;
    }

    public function getAVGrank()
    {
        $avg = 0; $cnt=0;
        foreach ($this->comments as $entry) {
            $avg += $entry->getRank();
            $cnt++; 
        }
        $avg = $cnt==0 ? 0 : $avg/$cnt;
        return round($avg);
    }
    
    public function __toString()
    {
        return $this->company;
    }
    
    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     *
     * @return Proposition
     */
    public function setImageFile(file $image = null)
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        //if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedat = new \DateTime();
        //}
         return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

}

<?php

// src/AppBundle/Entity/Skipper.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="skipper")
 * @Gedmo\TranslationEntity(class="AppBundle\Entity\SkipperTranslation")
 */
class Skipper {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
    * @Gedmo\Translatable
    * @ORM\Column(type="string", length=100)
    */
    protected $name;
    
    /**
    * @ORM\Column(type="string", length=100)
    */
    protected $email;
    
    /**
    * @Gedmo\Translatable
    * @ORM\Column(type="text")
    */
    protected $description;
    
    /**
    * @ORM\Column(type="string", length=30)
    */
    protected $yearsSailing;
    
    /**
    * @ORM\Column(type="string", length=30)
    */
    protected $professionalSince;
    
    /**
    * @ORM\Column(type="string", length=30)
    */
    protected $certificationDate;
    
    /**
    * @ORM\Column(type="string", length=30)
    */
    protected $yearsSailingCarribean;
    
    /**
    * @ORM\Column(type="string", length=30)
    */
    protected $yearsKiteSurfing;
    
    /**
    * @ORM\Column(type="string", length=30)
    */
    protected $yearsKiteCruise;
    
    /**
    * @ORM\Column(type="string", length=30)
    */
    protected $kitesurfInstructorSince;
    
    /**
    * @ORM\Column(type="string", length=30)
    */
    protected $kitesurfCertificationDate;
    
    /**
    * @ORM\Column(type="string", length=200)
    */
    protected $otherCertification;
    
    /**
    * @Gedmo\Translatable
    * @ORM\Column(type="string", length=200)
    */
    protected $hobbies;
    
    /**
    * @Gedmo\Translatable
    * @ORM\Column(type="string", length=200)
    */
    protected $languagesSpoken;
    
    /**
    * @Gedmo\Translatable
    * @ORM\Column(type="string", length=200)
    */
    protected $greatestQualities;
    
    /**
    * @ORM\Column(type="string", length=200)
    */
    protected $avatar;
    
    /**
    * @ORM\Column(type="integer")
    */
    protected $rank;
    
    
    /**
     * @ORM\Column(type="boolean")
     */
    protected $published;
    
    /**
     * @ORM\OneToMany(targetEntity="SkipperTranslation", mappedBy="object", cascade={"persist", "remove"})
     */
    protected $translations;

    /**
     * Required for Translatable behaviour
     * @Gedmo\Locale
     */
    protected $locale;

    public function __construct()
    {
        $this->translations = new ArrayCollection;
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
     * Set name
     *
     * @param string $name
     * @return Skipper
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
     * Set email
     *
     * @param string $email
     * @return Skipper
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Skipper
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set yearsSailing
     *
     * @param string $yearsSailing
     * @return Skipper
     */
    public function setYearsSailing($yearsSailing)
    {
        $this->yearsSailing = $yearsSailing;

        return $this;
    }

    /**
     * Get yearsSailing
     *
     * @return string 
     */
    public function getYearsSailing()
    {
        return $this->yearsSailing;
    }

    /**
     * Set professionalSince
     *
     * @param string $professionalSince
     * @return Skipper
     */
    public function setProfessionalSince($professionalSince)
    {
        $this->professionalSince = $professionalSince;

        return $this;
    }

    /**
     * Get professionalSince
     *
     * @return string 
     */
    public function getProfessionalSince()
    {
        return $this->professionalSince;
    }

    /**
     * Set certificationDate
     *
     * @param string $certificationDate
     * @return Skipper
     */
    public function setCertificationDate($certificationDate)
    {
        $this->certificationDate = $certificationDate;

        return $this;
    }

    /**
     * Get certificationDate
     *
     * @return string 
     */
    public function getCertificationDate()
    {
        return $this->certificationDate;
    }

    /**
     * Set yearsSailingCarribean
     *
     * @param string $yearsSailingCarribean
     * @return Skipper
     */
    public function setYearsSailingCarribean($yearsSailingCarribean)
    {
        $this->yearsSailingCarribean = $yearsSailingCarribean;

        return $this;
    }

    /**
     * Get yearsSailingCarribean
     *
     * @return string 
     */
    public function getYearsSailingCarribean()
    {
        return $this->yearsSailingCarribean;
    }

    /**
     * Set yearsKiteSurfing
     *
     * @param string $yearsKiteSurfing
     * @return Skipper
     */
    public function setYearsKiteSurfing($yearsKiteSurfing)
    {
        $this->yearsKiteSurfing = $yearsKiteSurfing;

        return $this;
    }

    /**
     * Get yearsKiteSurfing
     *
     * @return string 
     */
    public function getYearsKiteSurfing()
    {
        return $this->yearsKiteSurfing;
    }

    /**
     * Set yearsKiteCruise
     *
     * @param string $yearsKiteCruise
     * @return Skipper
     */
    public function setYearsKiteCruise($yearsKiteCruise)
    {
        $this->yearsKiteCruise = $yearsKiteCruise;

        return $this;
    }

    /**
     * Get yearsKiteCruise
     *
     * @return string 
     */
    public function getYearsKiteCruise()
    {
        return $this->yearsKiteCruise;
    }

    /**
     * Set kitesurfInstructorSince
     *
     * @param string $kitesurfInstructorSince
     * @return Skipper
     */
    public function setKitesurfInstructorSince($kitesurfInstructorSince)
    {
        $this->kitesurfInstructorSince = $kitesurfInstructorSince;

        return $this;
    }

    /**
     * Get kitesurfInstructorSince
     *
     * @return string 
     */
    public function getKitesurfInstructorSince()
    {
        return $this->kitesurfInstructorSince;
    }

    /**
     * Set kitesurfCertificationDate
     *
     * @param string $kitesurfCertificationDate
     * @return Skipper
     */
    public function setKitesurfCertificationDate($kitesurfCertificationDate)
    {
        $this->kitesurfCertificationDate = $kitesurfCertificationDate;

        return $this;
    }

    /**
     * Get kitesurfCertificationDate
     *
     * @return string 
     */
    public function getKitesurfCertificationDate()
    {
        return $this->kitesurfCertificationDate;
    }

    /**
     * Set otherCertification
     *
     * @param string $otherCertification
     * @return Skipper
     */
    public function setOtherCertification($otherCertification)
    {
        $this->otherCertification = $otherCertification;

        return $this;
    }

    /**
     * Get otherCertification
     *
     * @return string 
     */
    public function getOtherCertification()
    {
        return $this->otherCertification;
    }

    /**
     * Set hobbies
     *
     * @param string $hobbies
     * @return Skipper
     */
    public function setHobbies($hobbies)
    {
        $this->hobbies = $hobbies;

        return $this;
    }

    /**
     * Get hobbies
     *
     * @return string 
     */
    public function getHobbies()
    {
        return $this->hobbies;
    }

    /**
     * Set languagesSpoken
     *
     * @param string $languagesSpoken
     * @return Skipper
     */
    public function setLanguagesSpoken($languagesSpoken)
    {
        $this->languagesSpoken = $languagesSpoken;

        return $this;
    }

    /**
     * Get languagesSpoken
     *
     * @return string 
     */
    public function getLanguagesSpoken()
    {
        return $this->languagesSpoken;
    }

    /**
     * Set greatestQualities
     *
     * @param string $greatestQualities
     * @return Skipper
     */
    public function setGreatestQualities($greatestQualities)
    {
        $this->greatestQualities = $greatestQualities;

        return $this;
    }

    /**
     * Get greatestQualities
     *
     * @return string 
     */
    public function getGreatestQualities()
    {
        return $this->greatestQualities;
    }

    /**
     * Set avatar
     *
     * @param string $avatar
     * @return Skipper
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return string 
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set published
     *
     * @param boolean $published
     * @return Skipper
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return boolean 
     */
    public function getPublished()
    {
        return $this->published;
    } 
    
    /**
     * Set rank
     *
     * @param integer $rank
     * @return Skipper
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
    
    public function getTranslations()
    {
        return $this->translations;
    }
    
    public function addTranslation(SkipperTranslation $t)
    {
        $this->translations->add($t);
        $t->setObject($this);
    }
    
    public function removeTranslation(SkipperTranslation $t)
    {
        $this->translations->removeElement($t);
    }
    
    public function setTranslations($translations)
    {
        $this->translations = $translations;
    }
    
}

<?php

// src/AppBundle/Entity/SkipperTranslation.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

/**
 * @ORM\Entity
 */
class SkipperTranslation implements \A2lix\I18nDoctrineBundle\Doctrine\Interfaces\OneLocaleInterface {
    
    use \A2lix\I18nDoctrineBundle\Doctrine\ORM\Util\Translation;
    
    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $name;
    
    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $email;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;
    
    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    protected $yearsSailing;
    
    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    protected $professionalSince;
    
    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    protected $certificationDate;
    
    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    protected $yearsSailingCarribean;
    
    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    protected $yearsKiteSurfing;
    
    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    protected $yearsKiteCruise;
    
    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    protected $kitesurfInstructorSince;
    
    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    protected $kitesurfCertificationDate;
    
    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $otherCertifications;
    
    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $hobbies;
    
    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $languagesSpoken;
    
    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $greatestQualities;
    
    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $avatar;
    
    protected $avatarFile;
    
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $rank;
    
    /**
     * @ORM\Column(type="boolean")
     */
    protected $published;
    
    protected $translations;
    
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
     * Set otherCertifications
     *
     * @param string $otherCertifications
     * @return Skipper
     */
    public function setOtherCertifications($otherCertifications)
    {
        $this->otherCertifications = $otherCertifications;
    
        return $this;
    }
    
    /**
     * Get otherCertifications
     *
     * @return string
     */
    public function getOtherCertifications()
    {
        return $this->otherCertifications;
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
     * Sets avatarFile.
     *
     * @param UploadedFile $avatarFile
     */
    public function setAvatarFile(UploadedFile $avatarFile = null)
    {
        $this->avatarFile = $avatarFile;
    }
    
    /**
     * Get avatarFile.
     *
     * @return UploadedFile
     */
    public function getAvatarFile()
    {
        return $this->avatarFile;
    }
    
    public function getAvatarAbsolutePath()
    {
        return null === $this->avatar
        ? null
        : $this->getUploadRootDir().'/'.$this->avatar;
    }
    
    public function getAvatarWebPath()
    {
        return null === $this->avatar
        ? null
        : $this->getUploadDir().'/'.$this->avatar;
    }
    
    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }
    
    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/avatar';
    }
    
    public function upload($basepath)
    {
        // the file property can be empty if the field is not required
        if (null === $this->avatarFile) {
            return;
        }
    
        if (null === $basepath) {
            return;
        }
    
        // we use the original file name here but you should
        // sanitize it at least to avoid any security issues
    
        // move takes the target directory and then the target filename to move to
        $this->avatarFile->move($this->getUploadRootDir($basepath), $this->avatarFile->getClientOriginalName());
    
        // set the path property to the filename where you'ved saved the file
        $this->setAvatar($this->avatarFile->getClientOriginalName());
    
        // clean up the file property as you won't need it anymore
        $this->avatarFile = null;
    }
}

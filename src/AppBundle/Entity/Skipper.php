<?php

// src/AppBundle/Entity/Skipper.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity
 * @ORM\Table(name="skipper")
 */
class Skipper
{
    
    use ORMBehaviors\Translatable\Translatable;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $email;

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
    protected $kitesurfCertification;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $languagesSpoken;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $avatar;

    protected $avatarFile;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $actif = false;

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
    
    // Need this method for the admin list template and front
    public function getDescription()
    {
        return $this->translate()->getDescription();
    }

    public function getOtherCertifications()
    {
        return $this->translate()->getOtherCertifications();
    }

    public function getHobbies()
    {
        return $this->translate()->getHobbies();
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
     * Set kitesurfCertification
     *
     * @param string $kitesurfCertification            
     * @return Skipper
     */
    public function setKitesurfCertification($kitesurfCertification)
    {
        $this->kitesurfCertification = $kitesurfCertification;
        
        return $this;
    }

    /**
     * Get kitesurfCertification
     *
     * @return string
     */
    public function getKitesurfCertification()
    {
        return $this->kitesurfCertification;
    }

    /**
     * Set languagesSpoken
     *
     * @param string $languagesSpoken            
     * @return Skipper
     */
    public function setLanguagesSpoken($languagesSpoken)
    {
        $this->languagesSpoken = implode(', ', $languagesSpoken);
        
        return $this;
    }

    /**
     * Get languagesSpoken
     *
     * @return string
     */
    public function getLanguagesSpoken()
    {
        return explode(', ', $this->languagesSpoken);
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

    public function getAvatarWebPath()
    {
        return null === $this->avatar ? null : $this->getUploadDir() . '/avatar/' . $this->avatar;
    }

    protected function getUploadDir()
    {
        return '/uploads/skipper';
    }

    protected function getUploadRootDir()
    {
        return __DIR__ . '/../../../web/' . $this->getUploadDir();
    }

    public function upload($basepath)
    {
        $this->uploadImage($this->avatarFile, "setAvatar");
    }

    public function uploadImage($file, $fctName)
    {
        if (null === $file) {
            return;
        }
        
        if ($fctName == "setAvatar") {
            $file->move($this->getUploadRootDir() . '/avatar/', $file->getClientOriginalName());
        } else {
            $file->move($this->getUploadRootDir() . '/', $file->getClientOriginalName());
        }
        
        // set the path property to the filename where you'ved saved the file
        $this->$fctName($file->getClientOriginalName());
        // clean up the file property as you won't need it anymore
        $file = null;
    }

    /**
     * Set actif
     *
     * @param boolean $actif            
     * @return Skipper
     */
    public function setActif($actif)
    {
        $this->actif = $actif;
        
        return $this;
    }

    /**
     * Get actif
     *
     * @return boolean
     */
    public function getActif()
    {
        return $this->actif;
    }

    public function __toString()
    {
        return $this->getName() ?  : "Nouveau skipper";
    }
}

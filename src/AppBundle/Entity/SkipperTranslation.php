<?php

// src/AppBundle/Entity/SkipperTranslation.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * 
 */
class SkipperTranslation
{
    
    use ORMBehaviors\Translatable\Translation;

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

    public function __construct()
    {
        
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
}

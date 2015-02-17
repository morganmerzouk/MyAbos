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
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;
    
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
    protected $greatestQualities;

    public function __construct()
    {
        
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

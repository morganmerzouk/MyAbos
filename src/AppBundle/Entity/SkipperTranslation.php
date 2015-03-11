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
     * @ORM\Column(type="integer")
     */
    protected $translatable_id;
    
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
        return stripslashes($this->description);
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
     * Set translatable_id
     *
     * @param string $translatable_id
     * @return PortDepartTranslation
     */
    public function setTranslatableId($translatable_id)
    {
        $this->translatable_id= $translatable_id;
    
        return $this;
    }
    
    /**
     * Get name
     *
     * @return string
     */
    public function getTranslatableId()
    {
        return $this->translatable_id;
    }
}

<?php

// src/AppBundle/Entity/ItineraireTranslation.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Entity
 */
class TarifCroisiereTranslation
{
    
    use ORMBehaviors\Translatable\Translation;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $name;

    /**
     * @ORM\Column(type="integer")
     */
    protected $translatable_id;

    /**
     * Set translatable_id
     *
     * @param string $translatable_id            
     * @return PortDepartTranslation
     */
    public function setTranslatableId($translatable_id)
    {
        $this->translatable_id = $translatable_id;
        
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

    /**
     * Set name
     *
     * @param string $name            
     * @return ItineraireTranslation
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
     * Set locale
     *
     * @param string $locale            
     * @return ItineraireTranslation
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
        
        return $this;
    }

    /**
     * Get locale
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }
}

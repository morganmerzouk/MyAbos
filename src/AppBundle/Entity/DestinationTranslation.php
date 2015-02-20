<?php

// src/AppBundle/Entity/DestinationTranslation.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Entity
 * 
 */
class DestinationTranslation
{
    
    use ORMBehaviors\Translatable\Translation;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $infosPratique;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $translatable_id;
    
    /**
     * Set name
     *
     * @param string $name
     * @return Destination
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
     * Set description
     *
     * @param string $description
     * @return Destination
     */
    public function setDescription($description)
    {
        $this->description = stripslashes($description);
        
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
     * Set description
     *
     * @param string $infosPratique
     * @return Destination
     */
    public function setInfosPratique($infosPratique)
    {
        $this->infosPratique = stripslashes($infosPratique);
        
        return $this;
    }
    
    /**
     * Get infosPratique
     *
     * @return string
     */
    public function getInfosPratique()
    {
        return $this->infosPratique;
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

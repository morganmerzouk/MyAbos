<?php

// src/AppBundle/Entity/InclusPrixTranslation.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Entity
 * 
 */
class InclusPrixTranslation
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
     * Set translatable_id
     *
     * @param string $translatable_id
     * @return ServicePayantTranslation
     */
    public function setTranslatableId($translatable_id)
    {
        $this->translatable_id= $translatable_id;
    
        return $this;
    }
    
    /**
     * Get translatable_id
     *
     * @return string
     */
    public function getTranslatableId() {
        return $this->translatable_id;
    }
}

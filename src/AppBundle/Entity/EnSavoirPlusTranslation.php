<?php

// src/AppBundle/Entity/EnSavoirPlusTranslation.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Entity
 * 
 */
class EnSavoirPlusTranslation
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $libelleLien2;
        
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $libelleLien3;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $libelleLien4;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $libelleLien5;
    
    /**
     * Set name
     *
     * @param string $name
     * @return EnSavoirPlus
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
     * @return EnSavoirPlus
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
     * Set libelleLien2
     *
     * @param string $libelleLien2
     * @return EnSavoirPlusTranslation
     */
    public function setLibelleLien2($libelleLien2)
    {
        $this->libelleLien2 = $libelleLien2;

        return $this;
    }

    /**
     * Get libelleLien2
     *
     * @return string 
     */
    public function getLibelleLien2()
    {
        return $this->libelleLien2;
    }

    /**
     * Set libelleLien3
     *
     * @param string $libelleLien3
     * @return EnSavoirPlusTranslation
     */
    public function setLibelleLien3($libelleLien3)
    {
        $this->libelleLien3 = $libelleLien3;

        return $this;
    }

    /**
     * Get libelleLien3
     *
     * @return string 
     */
    public function getLibelleLien3()
    {
        return $this->libelleLien3;
    }

    /**
     * Set libelleLien4
     *
     * @param string $libelleLien4
     * @return EnSavoirPlusTranslation
     */
    public function setLibelleLien4($libelleLien4)
    {
        $this->libelleLien4 = $libelleLien4;

        return $this;
    }

    /**
     * Get libelleLien4
     *
     * @return string 
     */
    public function getLibelleLien4()
    {
        return $this->libelleLien4;
    }

    /**
     * Set libelleLien5
     *
     * @param string $libelleLien5
     * @return EnSavoirPlusTranslation
     */
    public function setLibelleLien5($libelleLien5)
    {
        $this->libelleLien5 = $libelleLien5;

        return $this;
    }

    /**
     * Get libelleLien5
     *
     * @return string 
     */
    public function getLibelleLien5()
    {
        return $this->libelleLien5;
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
     * Set locale
     *
     * @param string $locale
     * @return EnSavoirPlusTranslation
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

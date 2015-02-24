<?php

// src/AppBundle/Entity/BateauTranslation.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Entity
 * 
 */
class BateauTranslation
{
    
    use ORMBehaviors\Translatable\Translation;

         
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $translatable_id;
        
    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $equipementCuisine;
    
    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $loisir;
    
    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $energie;
    
    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $canot;
    
    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $jouet;
    
    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $autre;
    
    /**
     * Set description
     *
     * @param string $description
     * @return Prestation
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
     * Set nbCabine
     *
     * @param integer $nbCabine
     * @return BateauTranslation
     */
    public function setNbCabine($nbCabine)
    {
        $this->nbCabine = $nbCabine;

        return $this;
    }

    /**
     * Get nbCabine
     *
     * @return integer 
     */
    public function getNbCabine()
    {
        return $this->nbCabine;
    }

    /**
     * Set nbDouche
     *
     * @param integer $nbDouche
     * @return BateauTranslation
     */
    public function setNbDouche($nbDouche)
    {
        $this->nbDouche = $nbDouche;

        return $this;
    }

    /**
     * Get nbDouche
     *
     * @return integer 
     */
    public function getNbDouche()
    {
        return $this->nbDouche;
    }

    /**
     * Set equipementCuisine
     *
     * @param string $equipementCuisine
     * @return BateauTranslation
     */
    public function setEquipementCuisine($equipementCuisine)
    {
        $this->equipementCuisine = $equipementCuisine;

        return $this;
    }

    /**
     * Get equipementCuisine
     *
     * @return string 
     */
    public function getEquipementCuisine()
    {
        return $this->equipementCuisine;
    }

    /**
     * Set loisir
     *
     * @param string $loisir
     * @return BateauTranslation
     */
    public function setLoisir($loisir)
    {
        $this->loisir = $loisir;

        return $this;
    }

    /**
     * Get loisir
     *
     * @return string 
     */
    public function getLoisir()
    {
        return $this->loisir;
    }

    /**
     * Set energie
     *
     * @param string $energie
     * @return BateauTranslation
     */
    public function setEnergie($energie)
    {
        $this->energie = $energie;

        return $this;
    }

    /**
     * Get energie
     *
     * @return string 
     */
    public function getEnergie()
    {
        return $this->energie;
    }

    /**
     * Set canot
     *
     * @param string $canot
     * @return BateauTranslation
     */
    public function setCanot($canot)
    {
        $this->canot = $canot;

        return $this;
    }

    /**
     * Get canot
     *
     * @return string 
     */
    public function getCanot()
    {
        return $this->canot;
    }

    /**
     * Set jouet
     *
     * @param string $jouet
     * @return BateauTranslation
     */
    public function setJouet($jouet)
    {
        $this->jouet = $jouet;

        return $this;
    }

    /**
     * Get jouet
     *
     * @return string 
     */
    public function getJouet()
    {
        return $this->jouet;
    }

    /**
     * Set autre
     *
     * @param string $autre
     * @return BateauTranslation
     */
    public function setAutre($autre)
    {
        $this->autre = $autre;

        return $this;
    }

    /**
     * Get autre
     *
     * @return string 
     */
    public function getAutre()
    {
        return $this->autre;
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

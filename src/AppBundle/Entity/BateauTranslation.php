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
    protected $dinghy;
    
    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $jouet;
    
    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $autre;
    

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $longueur;
    
    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $largeur;
    
    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $tirantdeau;
    
    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $surfaceGrandVoile;
    
    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $moteur;
    
    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $reservoirCarburant;
    
    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $reservoirEau;
    

    /**
     * Set longueur
     *
     * @param string $longueur
     * @return Bateau
     */
    public function setLongueur($longueur)
    {
        $this->longueur = $longueur;
    
        return $this;
    }
    
    /**
     * Get longueur
     *
     * @return string
     */
    public function getLongueur()
    {
        return $this->longueur;
    }
    
    /**
     * Set largeur
     *
     * @param string $largeur
     * @return Bateau
     */
    public function setLargeur($largeur)
    {
        $this->largeur = $largeur;
    
        return $this;
    }
    
    /**
     * Get largeur
     *
     * @return string
     */
    public function getLargeur()
    {
        return $this->largeur;
    }
    
    /**
     * Set moteur
     *
     * @param string $moteur
     * @return Bateau
     */
    public function setMoteur($moteur)
    {
        $this->moteur = $moteur;
    
        return $this;
    }
    
    /**
     * Get moteur
     *
     * @return string
     */
    public function getMoteur()
    {
        return $this->moteur;
    }
    
    /**
     * Set tirantdeau
     *
     * @param string $tirantdeau
     * @return Bateau
     */
    public function setTirantdeau($tirantdeau)
    {
        $this->tirantdeau = $tirantdeau;
    }
    
    /**
     * Get tirantdeau
     *
     * @return string
     */
    public function getTirantdeau()
    {
        return $this->tirantdeau;
    }
    
    /**
     * Set surfaceGrandVoile
     *
     * @param string $surfaceGrandVoile
     * @return Bateau
     */
    public function setSurfaceGrandVoile($surfaceGrandVoile)
    {
        $this->surfaceGrandVoile = $surfaceGrandVoile;
    
        return $this;
    }
    
    /**
     * Get surfaceGrandVoile
     *
     * @return string
     */
    public function getSurfaceGrandVoile()
    {
        return $this->surfaceGrandVoile;
    }
    
    /**
     * Set reservoirCarburant
     *
     * @param string $reservoirCarburant
     * @return Bateau
     */
    public function setReservoirCarburant($reservoirCarburant)
    {
        $this->reservoirCarburant = $reservoirCarburant;
    
        return $this;
    }
    
    /**
     * Get reservoirCarburant
     *
     * @return string
     */
    public function getReservoirCarburant()
    {
        return $this->reservoirCarburant;
    }
    
    /**
     * Set reservoirEau
     *
     * @param string $reservoirEau
     * @return Bateau
     */
    public function setReservoirEau($reservoirEau)
    {
        $this->reservoirEau = $reservoirEau;
    
        return $this;
    }
    
    /**
     * Get reservoirEau
     *
     * @return string
     */
    public function getReservoirEau()
    {
        return $this->reservoirEau;
    }
    
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
     * Set dinghy
     *
     * @param string $dinghy
     * @return BateauTranslation
     */
    public function setDinghy($dinghy)
    {
        $this->dinghy = $dinghy;

        return $this;
    }

    /**
     * Get dinghy
     *
     * @return string 
     */
    public function getDinghy()
    {
        return $this->dinghy;
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

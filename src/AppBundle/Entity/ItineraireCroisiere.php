<?php

// src/AppBundle/Entity/ItineraireCroisiere.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity
 * @ORM\Table(name="itinerairecroisiere")
 */
class ItineraireCroisiere
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Itineraire")
     */
    protected $itineraire;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    protected $dateDebut;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    protected $dateFin;

    /**
     * Constructor
     */
    public function __construct()
    {}

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this->getItineraire()->getName();
    }

    /**
     * Set dateDebut
     *
     * @param \DateTime $dateDebut            
     * @return DateNonDisponibilite
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;
        
        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return \DateTime
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set dateFin
     *
     * @param \DateTime $dateFin            
     * @return DateNonDisponibilite
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;
        
        return $this;
    }

    /**
     * Get dateFin
     *
     * @return \DateTime
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * Set nombreJourMinimum
     *
     * @param integer $nombreJourMinimum            
     * @return TarifCroisiere
     */
    public function setNombreJourMinimum($nombreJourMinimum)
    {
        $this->nombreJourMinimum = $nombreJourMinimum;
        
        return $this;
    }

    /**
     * Get nombreJourMinimum
     *
     * @return integer
     */
    public function getNombreJourMinimum()
    {
        return $this->nombreJourMinimum;
    }

    /**
     * Set nombreJourMaximum
     *
     * @param integer $nombreJourMaximum            
     * @return TarifCroisiere
     */
    public function setNombreJourMaximum($nombreJourMaximum)
    {
        $this->nombreJourMaximum = $nombreJourMaximum;
        
        return $this;
    }

    /**
     * Get nombreJourMaximum
     *
     * @return integer
     */
    public function getNombreJourMaximum()
    {
        return $this->nombreJourMaximum;
    }

    /**
     * Set itineraire
     *
     * @param \AppBundle\Entity\Itineraire $itineraire            
     * @return ItineraireCroisiere
     */
    public function setItineraire(\AppBundle\Entity\Itineraire $itineraire = null)
    {
        $this->itineraire = $itineraire;
        
        return $this;
    }

    /**
     * Get itineraire
     *
     * @return \AppBundle\Entity\Itineraire
     */
    public function getItineraire()
    {
        return $this->itineraire;
    }
}

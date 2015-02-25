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
     * @ORM\OneToOne(targetEntity="Itineraire")
     */
    protected $itineraire;
    
    /**
     * @ORM\Column(type="datetime")
     */
    protected $dateDebut;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $dateFin;
    
    /**
     * @ORM\Column(type="integer", length=200, nullable=true)
     */
    protected $variationPrix;
    
    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $tarifAppliqueSur;
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
        return (string) 'Du ' . $this->getDateDebut()->format('d/m/Y') . ' au ' . $this->getDateFin()->format('d/m/Y') . ' pour ' . $this->tarifPour;
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
     * Set tarifDeuxPersonnes
     *
     * @param integer $tarifDeuxPersonnes
     * @return TarifCroisiere
     */
    public function setTarifDeuxPersonnes($tarifDeuxPersonnes)
    {
        $this->tarifDeuxPersonnes = $tarifDeuxPersonnes;

        return $this;
    }

    /**
     * Get tarifDeuxPersonnes
     *
     * @return integer 
     */
    public function getTarifDeuxPersonnes()
    {
        return $this->tarifDeuxPersonnes;
    }

    /**
     * Set tarifTroisPersonnes
     *
     * @param integer $tarifTroisPersonnes
     * @return TarifCroisiere
     */
    public function setTarifTroisPersonnes($tarifTroisPersonnes)
    {
        $this->tarifTroisPersonnes = $tarifTroisPersonnes;

        return $this;
    }

    /**
     * Get tarifTroisPersonnes
     *
     * @return integer 
     */
    public function getTarifTroisPersonnes()
    {
        return $this->tarifTroisPersonnes;
    }

    /**
     * Set tarifQuatrePersonnes
     *
     * @param integer $tarifQuatrePersonnes
     * @return TarifCroisiere
     */
    public function setTarifQuatrePersonnes($tarifQuatrePersonnes)
    {
        $this->tarifQuatrePersonnes = $tarifQuatrePersonnes;

        return $this;
    }

    /**
     * Get tarifQuatrePersonnes
     *
     * @return integer 
     */
    public function getTarifQuatrePersonnes()
    {
        return $this->tarifQuatrePersonnes;
    }

    /**
     * Set tarifCinqPersonnes
     *
     * @param integer $tarifCinqPersonnes
     * @return TarifCroisiere
     */
    public function setTarifCinqPersonnes($tarifCinqPersonnes)
    {
        $this->tarifCinqPersonnes = $tarifCinqPersonnes;

        return $this;
    }

    /**
     * Get tarifCinqPersonnes
     *
     * @return integer 
     */
    public function getTarifCinqPersonnes()
    {
        return $this->tarifCinqPersonnes;
    }

    /**
     * Set tarifSixPersonnes
     *
     * @param integer $tarifSixPersonnes
     * @return TarifCroisiere
     */
    public function setTarifSixPersonnes($tarifSixPersonnes)
    {
        $this->tarifSixPersonnes = $tarifSixPersonnes;

        return $this;
    }

    /**
     * Get tarifSixPersonnes
     *
     * @return integer 
     */
    public function getTarifSixPersonnes()
    {
        return $this->tarifSixPersonnes;
    }

    /**
     * Set tarifSeptPersonnes
     *
     * @param integer $tarifSeptPersonnes
     * @return TarifCroisiere
     */
    public function setTarifSeptPersonnes($tarifSeptPersonnes)
    {
        $this->tarifSeptPersonnes = $tarifSeptPersonnes;

        return $this;
    }

    /**
     * Get tarifSeptPersonnes
     *
     * @return integer 
     */
    public function getTarifSeptPersonnes()
    {
        return $this->tarifSeptPersonnes;
    }

    /**
     * Set tarifHuitPersonnes
     *
     * @param integer $tarifHuitPersonnes
     * @return TarifCroisiere
     */
    public function setTarifHuitPersonnes($tarifHuitPersonnes)
    {
        $this->tarifHuitPersonnes = $tarifHuitPersonnes;

        return $this;
    }

    /**
     * Get tarifHuitPersonnes
     *
     * @return integer 
     */
    public function getTarifHuitPersonnes()
    {
        return $this->tarifHuitPersonnes;
    }

    /**
     * Set tarifPour
     *
     * @param string $tarifPour
     * @return TarifCroisiere
     */
    public function setTarifPour($tarifPour)
    {
        $this->tarifPour = $tarifPour;

        return $this;
    }

    /**
     * Get tarifPour
     *
     * @return string 
     */
    public function getTarifPour()
    {
        return $this->tarifPour;
    }

    /**
     * Set variationPrix
     *
     * @param integer $variationPrix
     * @return ItineraireCroisiere
     */
    public function setVariationPrix($variationPrix)
    {
        $this->variationPrix = $variationPrix;

        return $this;
    }

    /**
     * Get variationPrix
     *
     * @return integer 
     */
    public function getVariationPrix()
    {
        return $this->variationPrix;
    }

    /**
     * Set tarifAppliqueSur
     *
     * @param string $tarifAppliqueSur
     * @return ItineraireCroisiere
     */
    public function setTarifAppliqueSur($tarifAppliqueSur)
    {
        $this->tarifAppliqueSur = $tarifAppliqueSur;

        return $this;
    }

    /**
     * Get tarifAppliqueSur
     *
     * @return string 
     */
    public function getTarifAppliqueSur()
    {
        return $this->tarifAppliqueSur;
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

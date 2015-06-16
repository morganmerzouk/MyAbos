<?php

// src/AppBundle/Entity/Devis.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity
 * @ORM\Table(name="devis")
 */
class Devis
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $nom;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $offreSpecialeId;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $prix;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $bateau;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $skipper;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    protected $dateDebut;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    protected $dateFin;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $nbPassager;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $itineraire;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $servicePayant;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $message;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $sendAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $readAt;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $actif = true;

    protected $mails;

    public function addMails($mail)
    {
        $this->mails[] = $mail;
    }

    public function getMails()
    {
        return $this->mails;
    }

    /**
     * Set id
     *
     * @param string $id            
     * @return Croisiere
     *
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * Set bateau
     *
     * @param string $bateau            
     * @return Devis
     */
    public function setBateau($bateau)
    {
        $this->bateau = $bateau;
        
        return $this;
    }

    /**
     * Get bateau
     *
     * @return string
     */
    public function getBateau()
    {
        return $this->bateau;
    }

    /**
     * Set skipper
     *
     * @param string $skipper            
     * @return Devis
     */
    public function setSkipper($skipper)
    {
        $this->skipper = $skipper;
        
        return $this;
    }

    /**
     * Get skipper
     *
     * @return string
     */
    public function getSkipper()
    {
        return $this->skipper;
    }

    /**
     * Set dateDebut
     *
     * @param string $dateDebut            
     * @return Devis
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;
        
        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return string
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set dateFin
     *
     * @param string $dateFin            
     * @return Devis
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;
        
        return $this;
    }

    /**
     * Get dateFin
     *
     * @return string
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * Set nbPassager
     *
     * @param string $nbPassager            
     * @return Devis
     */
    public function setNbPassager($nbPassager)
    {
        $this->nbPassager = $nbPassager;
        
        return $this;
    }

    /**
     * Get nbPassager
     *
     * @return string
     */
    public function getNbPassager()
    {
        return $this->nbPassager;
    }

    /**
     * Set itineraire
     *
     * @param string $itineraire            
     * @return Devis
     */
    public function setItineraire($itineraire)
    {
        $this->itineraire = $itineraire;
        
        return $this;
    }

    /**
     * Get itineraire
     *
     * @return string
     */
    public function getItineraire()
    {
        return $this->itineraire;
    }

    /**
     * Set servicePayant
     *
     * @param string $servicePayant            
     * @return Devis
     */
    public function setServicePayant($servicePayant)
    {
        $this->servicePayant = $servicePayant;
        
        return $this;
    }

    /**
     * Get servicePayant
     *
     * @return string
     */
    public function getServicePayant()
    {
        return $this->servicePayant;
    }

    /**
     * Set message
     *
     * @param string $message            
     * @return Devis
     */
    public function setMessage($message)
    {
        $this->message = $message;
        
        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set nom
     *
     * @param string $nom            
     * @return Devis
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
        
        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set email
     *
     * @param string $email            
     * @return Devis
     */
    public function setEmail($email)
    {
        $this->email = $email;
        
        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set prix
     *
     * @param string $prix            
     * @return Devis
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;
        
        return $this;
    }

    /**
     * Get prix
     *
     * @return string
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt            
     * @return Devis
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set offreSpecialeId
     *
     * @param string $offreSpecialeId            
     * @return Devis
     */
    public function setOffreSpecialeId($offreSpecialeId)
    {
        $this->offreSpecialeId = $offreSpecialeId;
        
        return $this;
    }

    /**
     * Get offreSpecialeId
     *
     * @return string
     */
    public function getOffreSpecialeId()
    {
        return $this->offreSpecialeId;
    }

    /**
     * Set sendAt
     *
     * @param \DateTime $sendAt            
     * @return Devis
     */
    public function setSendAt($sendAt)
    {
        $this->sendAt = $sendAt;
        
        return $this;
    }

    /**
     * Get sendAt
     *
     * @return \DateTime
     */
    public function getSendAt()
    {
        return $this->sendAt;
    }

    /**
     * Set readAt
     *
     * @param \DateTime $readAt            
     * @return Devis
     */
    public function setReadAt($readAt)
    {
        $this->readAt = $readAt;
        
        return $this;
    }

    /**
     * Get readAt
     *
     * @return \DateTime
     */
    public function getReadAt()
    {
        return $this->readAt;
    }

    /**
     * Set actif
     *
     * @param boolean $actif            
     * @return Devis
     */
    public function setActif($actif)
    {
        $this->actif = $actif;
        
        return $this;
    }

    /**
     * Get actif
     *
     * @return boolean
     */
    public function getActif()
    {
        return $this->actif;
    }
}

<?php

// src/AppBundle/Entity/Croisiere.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity
 * @ORM\Table(name="offrespeciale")
 */
class OffreSpeciale
{
    
    use ORMBehaviors\Translatable\Translatable;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Bateau", cascade={"persist"})
     */
    protected $bateau;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Skipper",cascade={"persist"})
     */
    protected $skipper;

    /**
     * @ORM\Column(type="date")
     */
    protected $dateDebut;

    /**
     * @ORM\Column(type="date")
     */
    protected $dateFin;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PortDepart", cascade={"remove"})
     */
    protected $portDepart;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Destination", inversedBy="itineraire", )
     */
    protected $destination;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $nbCabine;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $tarifUnePersonne;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $tarifDeuxPersonnes;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $tarifTroisPersonnes;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $tarifQuatrePersonnes;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $tarifCinqPersonnes;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $tarifSixPersonnes;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $tarifSeptPersonnes;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $tarifHuitPersonnes;

    /**
     * @ORM\Column(type="string", length=200)
     */
    protected $tarifPour;

    /**
     * @ORM\OneToOne(targetEntity="Itineraire",cascade={"persist"})
     */
    protected $itineraire;

    /**
     * @ORM\ManyToMany(targetEntity="ServicePayant")
     */
    protected $servicePayant;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $miniature;

    protected $miniatureFile;

    public function __clone()
    {
        $this->id = null;
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
     * Set miniature
     *
     * @param string $miniature            
     * @return Croisiere
     */
    public function setMiniature($miniature)
    {
        $this->miniature = $miniature;
        
        return $this;
    }

    /**
     * Get miniature
     *
     * @return string
     */
    public function getMiniature()
    {
        return $this->miniature;
    }

    /**
     * Sets miniatureFile.
     *
     * @param UploadedFile $miniatureFile            
     */
    public function setMiniatureFile(UploadedFile $miniatureFile = null)
    {
        $this->miniatureFile = $miniatureFile;
    }

    /**
     * Get miniatureFile.
     *
     * @return UploadedFile
     */
    public function getMiniatureFile()
    {
        return $this->miniatureFile;
    }

    public function getMiniatureWebPath()
    {
        return null === $this->miniature ? null : $this->getUploadDir() . '/miniature/' . $this->miniature;
    }

    protected function getUploadDir()
    {
        return '/uploads/offrespeciale';
    }

    protected function getUploadRootDir()
    {
        return __DIR__ . '/../../../web/' . $this->getUploadDir();
    }

    public function upload($basepath)
    {
        $this->uploadImage($this->miniatureFile, "setMiniature");
    }

    public function uploadImage($file, $fctName)
    {
        if (null === $file) {
            return;
        }
        
        $file->move($this->getUploadRootDir() . '/miniature/', $file->getClientOriginalName());
        
        // set the path property to the filename where you'ved saved the file
        $this->$fctName($file->getClientOriginalName());
        // clean up the file property as you won't need it anymore
        $file = null;
    }

    public function __toString()
    {
        return $this->getName() ?  : 'Nouvel croisière';
    }

    /* hack */
    public function __call($method, $arguments)
    {
        return $this->proxyCurrentLocaleTranslation($method, $arguments);
    }
    
    // Need this method for the admin list template
    public function getName()
    {
        return $this->translate()->getName();
    }

    public function getDescription()
    {
        return $this->translate()->getDescription();
    }

    /**
     * Set bateau
     *
     * @param \AppBundle\Entity\Bateau $bateau            
     * @return Croisiere
     */
    public function setBateau(\AppBundle\Entity\Bateau $bateau = null)
    {
        $this->bateau = $bateau;
        
        return $this;
    }

    /**
     * Get bateau
     *
     * @return \AppBundle\Entity\Bateau
     */
    public function getBateau()
    {
        return $this->bateau;
    }

    /**
     * Set skipper
     *
     * @param \AppBundle\Entity\Skipper $skipper            
     * @return Croisiere
     */
    public function setSkipper(\AppBundle\Entity\Skipper $skipper = null)
    {
        $this->skipper = $skipper;
        
        return $this;
    }

    /**
     * Get skipper
     *
     * @return \AppBundle\Entity\Skipper
     */
    public function getSkipper()
    {
        return $this->skipper;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->servicePayant = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add servicePayant
     *
     * @param \AppBundle\Entity\ServicePayant $servicePayant            
     * @return OffreSpeciale
     */
    public function addServicePayant(\AppBundle\Entity\ServicePayant $servicePayant)
    {
        $this->servicePayant[] = $servicePayant;
        
        return $this;
    }

    /**
     * Remove servicePayant
     *
     * @param \AppBundle\Entity\ServicePayant $servicePayant            
     */
    public function removeServicePayant(\AppBundle\Entity\ServicePayant $servicePayant)
    {
        $this->servicePayant->removeElement($servicePayant);
    }

    /**
     * Get servicePayant
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getServicePayant()
    {
        return $this->servicePayant;
    }

    /**
     * Set dateDebut
     *
     * @param \DateTime $dateDebut            
     * @return OffreSpeciale
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
     * @return OffreSpeciale
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
     * Set tarifDeuxPersonnes
     *
     * @param integer $tarifDeuxPersonnes            
     * @return OffreSpeciale
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
     * @return OffreSpeciale
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
     * @return OffreSpeciale
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
     * @return OffreSpeciale
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
     * @return OffreSpeciale
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
     * @return OffreSpeciale
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
     * @return OffreSpeciale
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
     * @return OffreSpeciale
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
     * Set portDepart
     *
     * @param \AppBundle\Entity\PortDepart $portDepart            
     * @return OffreSpeciale
     */
    public function setPortDepart(\AppBundle\Entity\PortDepart $portDepart = null)
    {
        $this->portDepart = $portDepart;
        
        return $this;
    }

    /**
     * Get portDepart
     *
     * @return \AppBundle\Entity\PortDepart
     */
    public function getPortDepart()
    {
        return $this->portDepart;
    }

    /**
     * Set destination
     *
     * @param \AppBundle\Entity\Destination $destination            
     * @return OffreSpeciale
     */
    public function setDestination(\AppBundle\Entity\Destination $destination = null)
    {
        $this->destination = $destination;
        
        return $this;
    }

    /**
     * Get destination
     *
     * @return \AppBundle\Entity\Destination
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * Set itineraire
     *
     * @param \AppBundle\Entity\Itineraire $itineraire            
     * @return OffreSpeciale
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

    /**
     * Set nbCabine
     *
     * @param integer $nbCabine            
     * @return OffreSpeciale
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
     * Set tarifUnePersonne
     *
     * @param integer $tarifUnePersonne
     * @return OffreSpeciale
     */
    public function setTarifUnePersonne($tarifUnePersonne)
    {
        $this->tarifUnePersonne = $tarifUnePersonne;

        return $this;
    }

    /**
     * Get tarifUnePersonne
     *
     * @return integer 
     */
    public function getTarifUnePersonne()
    {
        return $this->tarifUnePersonne;
    }
}

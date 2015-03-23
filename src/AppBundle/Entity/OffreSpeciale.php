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
     * @ORM\OneToOne(targetEntity="TarifCroisiere",cascade={"remove"})
     */
    protected $tarif;

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
        $this->uploadImage($this->miniatureFile, "setMiniature", 125, 125);
    }

    public function uploadImage($file, $fctName, $width, $height)
    {
        if (null === $file) {
            return;
        }
        $destination = imagecreatetruecolor($width, $height);
        
        $extension = $file->getClientOriginalExtension();
        switch (strtolower($extension)) {
            case "png":
                $source = imagecreatefrompng($file);
                imagealphablending($destination, false);
                $colorTransparent = imagecolorallocatealpha($destination, 0, 0, 0, 0x7fff0000);
                imagefill($destination, 0, 0, $colorTransparent);
                imagesavealpha($destination, true);
                $fct = 'imagepng';
                break;
            case "jpg":
            case "jpeg":
                $source = imagecreatefromjpeg($file);
                $fct = 'imagejpeg';
                break;
            case "gif":
                $source = imagecreatefromgif($file);
                $fct = 'imagegif';
                break;
        }
        
        // On r�cup�re la taille de l'image source
        $largeur_source = imagesx($source);
        $hauteur_source = imagesy($source);
        
        // On redimensionne tout !
        imagecopyresampled($destination, $source, 0, 0, 0, 0, $width, $height, $largeur_source, $hauteur_source);
        if ($fctName == "setMiniature") {
            $fct($destination, $this->getUploadRootDir() . '/miniature/' . $file->getClientOriginalName());
        } else {
            $fct($destination, $this->getUploadRootDir() . '/' . $file->getClientOriginalName());
        }
        
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
     * Set tarif
     *
     * @param \AppBundle\Entity\TarifCroisiere $tarif
     * @return OffreSpeciale
     */
    public function setTarif(\AppBundle\Entity\TarifCroisiere $tarif = null)
    {
        $this->tarif = $tarif;
    
        return $this;
    }

    /**
     * Get tarif
     *
     * @return \AppBundle\Entity\TarifCroisiere 
     */
    public function getTarif()
    {
        return $this->tarif;
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
}
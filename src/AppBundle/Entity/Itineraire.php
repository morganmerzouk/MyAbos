<?php

// src/AppBundle/Entity/Itineraire.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity
 * @ORM\Table(name="itineraire")
 */
class Itineraire
{
    
    use ORMBehaviors\Translatable\Translatable;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PortDepart", cascade={"remove"})
     */
    protected $portDepart;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Destination", inversedBy="itineraire", )
     */
    protected $destination;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $miniature;

    protected $miniatureFile;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->destination = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return PortDepart
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

    /**
     * Add destination
     *
     * @param \AppBundle\Entity\Destination $destination            
     * @return Itineraire
     */
    public function setDestination(\AppBundle\Entity\Destination $destination)
    {
        $this->destination = $destination;
        
        return $this;
    }

    /**
     * Get destination
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * Set portDepart
     *
     * @param \AppBundle\Entity\PortDepart $portDepart            
     * @return PortDepart
     */
    public function setPortDepart(\AppBundle\Entity\PortDepart $portDepart)
    {
        $this->portDepart = $portDepart;
        
        return $this;
    }

    /**
     * Get portDepart
     *
     * @return PortDepart
     */
    public function getPortDepart()
    {
        return $this->portDepart;
    }

    public function getMiniatureWebPath()
    {
        return null === $this->miniature ? null : $this->getUploadDir() . '/miniature/' . $this->miniature;
    }

    protected function getUploadDir()
    {
        return '/uploads/itineraire';
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

    /**
     * Add destination
     *
     * @param \AppBundle\Entity\Destination $destination            
     * @return Itineraire
     */
    public function addDestination(\AppBundle\Entity\Destination $destination)
    {
        $this->destination[] = $destination;
        
        return $this;
    }

    public function __toString()
    {
        if (! $this->getPortDepart())
            return 'Nouvel itinéraire';
        return (string) $this->getPortDepart()->getName() . '-' . $this->getDestination()->getName();
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
     * Add portDepart
     *
     * @param \AppBundle\Entity\PortDepart $portDepart            
     * @return Itineraire
     */
    public function addPortDepart(\AppBundle\Entity\PortDepart $portDepart)
    {
        $this->portDepart[] = $portDepart;
        
        return $this;
    }

    /**
     * Remove portDepart
     *
     * @param \AppBundle\Entity\PortDepart $portDepart            
     */
    public function removePortDepart(\AppBundle\Entity\PortDepart $portDepart)
    {
        $this->portDepart->removeElement($portDepart);
    }

    /**
     * Remove destination
     *
     * @param \AppBundle\Entity\Destination $destination            
     */
    public function removeDestination(\AppBundle\Entity\Destination $destination)
    {
        $this->destination->removeElement($destination);
    }
}

<?php

// src/AppBundle/Entity/Destination.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity
 * @ORM\Table(name="destination")
 */
class Destination
{
    
    use ORMBehaviors\Translatable\Translatable;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Itineraire", mappedBy="destination", cascade={"persist", "remove"})
     */
    private $itineraire;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $flag;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $latitude;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $longitude;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $miniature;

    protected $miniatureFile;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public function getDescription()
    {
        return $this->translate()->getDescription();
    }

    /**
     * Set miniature
     *
     * @param
     *            string miniature
     * @return Destination
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
        return '/uploads/destination';
    }

    public function getFlagWebPath()
    {
        return null === $this->flag ? null : $this->getUploadDir() . '/flag/' . $this->flag;
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
    
    // Work even the precedent method not here, the proxy call work fine.
    public function __toString()
    {
        return $this->getName() ?  : "Nouvelle destination";
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->itineraire = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add itineraire
     *
     * @param \AppBundle\Entity\Itineraire $itineraire            
     * @return Destination
     */
    public function addItineraire(\AppBundle\Entity\Itineraire $itineraire)
    {
        $this->itineraire[] = $itineraire;
        
        return $this;
    }

    /**
     * Remove itineraire
     *
     * @param \AppBundle\Entity\Itineraire $itineraire            
     */
    public function removeItineraire(\AppBundle\Entity\Itineraire $itineraire)
    {
        $this->itineraire->removeElement($itineraire);
    }

    /**
     * Get itineraire
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getItineraire()
    {
        return $this->itineraire;
    }

    /**
     * Set flag
     *
     * @param string $flag            
     * @return Destination
     */
    public function setFlag($flag)
    {
        $this->flag = $flag;
        
        return $this;
    }

    /**
     * Get flag
     *
     * @return string
     */
    public function getFlag()
    {
        return $this->flag;
    }

    /**
     * Set latitude
     *
     * @param string $latitude            
     * @return Destination
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
        
        return $this;
    }

    /**
     * Get latitude
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude            
     * @return Destination
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
        
        return $this;
    }

    /**
     * Get longitude
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }
}

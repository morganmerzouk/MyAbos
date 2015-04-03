<?php

// src/AppBundle/Entity/Skipper.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity
 * @ORM\Table(name="portdepart")
 */
class PortDepart
{
    
    use ORMBehaviors\Translatable\Translatable;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    protected $name;

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
        $this->itineraire = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add itineraire
     *
     * @param \AppBundle\Entity\Itineraire $itineraire            
     * @return PortDepart
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

    public function getMiniatureWebPath()
    {
        return null === $this->miniature ? null : $this->getUploadDir() . '/miniature/' . $this->miniature;
    }

    protected function getUploadDir()
    {
        return '/uploads/portdepart';
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
        return $this->getName() ?  : "Nouveau port";
    }

    /**
     * Set itineraire
     *
     * @param \AppBundle\Entity\Itineraire $itineraire            
     * @return PortDepart
     */
    public function setItineraire(\AppBundle\Entity\Itineraire $itineraire = null)
    {
        $this->itineraire = $itineraire;
        
        return $this;
    }
}

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
        return (string) $this->getName();
    }

    /* hack */
    public function __call($method, $arguments)
    {
        return $this->proxyCurrentLocaleTranslation($method, $arguments);
    }
    
    // Need this method for the admin list template
    public function getDescription()
    {
        return $this->translate()->getDescription();
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

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
class PortDepart {

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
     * @ORM\Column(type="boolean")
     */
    protected $published;
        
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
     * Set published
     *
     * @param boolean $published
     * @return PortDepart
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return boolean 
     */
    public function getPublished()
    {
        return $this->published;
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
        return null === $this->miniature
        ? null
        : $this->getUploadDir().'/miniature/'.$this->miniature;
    }
    
    protected function getUploadDir()
    {
        return '/uploads/portdepart';
    }
        
    protected function getUploadRootDir(){
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }
        
    public function upload($basepath)
    {
        $this->uploadImage($this->miniatureFile, "setMiniature", 125, 125);
    }
    
    public function uploadImage($file, $fctName, $width, $height){

        if (null === $file) {
            return;
        }
        $destination = imagecreatetruecolor($width, $height);

        $extension = $file->getClientOriginalExtension();
        switch (strtolower($extension)) {
            case "png":
                $source = imagecreatefrompng($file);
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
    
    
    /* hack */
    public function __call($method, $arguments)
    {
        return $this->proxyCurrentLocaleTranslation($method, $arguments);
    }   

    // Need this method for the admin list template
    public function getName(){
         return $this->translate()->getName();
    }

    // Work even the precedent method not here, the proxy call work fine.
    public function __toString(){
         return $this->getName() ?: "Nouveau port";
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

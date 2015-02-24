<?php

// src/AppBundle/Entity/Croisiere.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity
 * @ORM\Table(name="croisiere")
 */
class Croisiere {

    use ORMBehaviors\Translatable\Translatable;
        
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Bateau", cascade={"remove"})
   */
    protected $bateau;
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Skipper",cascade={"remove"})
     */
    protected $skipper;
    
    /**
     * @ORM\ManyToMany(targetEntity="DateNonDisponibilite")
     */
    protected $dateNonDisponibilite;
    /**
     * @ORM\ManyToMany(targetEntity="TarifCroisiere")
     */
    protected $tarifCroisiere;
    
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
        $this->dateNonDisponibilite=new \Doctrine\Common\Collections\ArrayCollection();;
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
    
    public function getMiniatureWebPath()
    {
        return null === $this->miniature
        ? null
        : $this->getUploadDir().'/miniature/'.$this->miniature;
    }
    
    protected function getUploadDir()
    {
        return '/uploads/croisiere';
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
    
    public function __toString()
    {
            return 'Nouvel croisi�re';
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
     * Set dateNonDisponibilite
     *
     * @param \AppBundle\Entity\DateNonDisponibilite $dateNonDisponibilite
     * @return Croisiere
     */
    public function setDateNonDisponibilite(\AppBundle\Entity\DateNonDisponibilite $dateNonDisponibilite = null)
    {
        $this->dateNonDisponibilite = $dateNonDisponibilite;

        return $this;
    }

    /**
     * Get dateNonDisponibilite
     *
     * @return \AppBundle\Entity\DateNonDisponibilite 
     */
    public function getDateNonDisponibilite()
    {
        return $this->dateNonDisponibilite;
    }

    /**
     * Add dateNonDisponibilite
     *
     * @param \AppBundle\Entity\DateNonDisponibilite $dateNonDisponibilite
     * @return Croisiere
     */
    public function addDateNonDisponibilite(\AppBundle\Entity\DateNonDisponibilite $dateNonDisponibilite)
    {
        $this->dateNonDisponibilite[] = $dateNonDisponibilite;

        return $this;
    }

    /**
     * Remove dateNonDisponibilite
     *
     * @param \AppBundle\Entity\DateNonDisponibilite $dateNonDisponibilite
     */
    public function removeDateNonDisponibilite(\AppBundle\Entity\DateNonDisponibilite $dateNonDisponibilite)
    {
        $this->dateNonDisponibilite->removeElement($dateNonDisponibilite);
    }

    /**
     * Add tarifCroisiere
     *
     * @param \AppBundle\Entity\TarifCroisiere $tarifCroisiere
     * @return Croisiere
     */
    public function addTarifCroisiere(\AppBundle\Entity\TarifCroisiere $tarifCroisiere)
    {
        $this->tarifCroisiere[] = $tarifCroisiere;

        return $this;
    }

    /**
     * Remove tarifCroisiere
     *
     * @param \AppBundle\Entity\TarifCroisiere $tarifCroisiere
     */
    public function removeTarifCroisiere(\AppBundle\Entity\TarifCroisiere $tarifCroisiere)
    {
        $this->tarifCroisiere->removeElement($tarifCroisiere);
    }

    /**
     * Get tarifCroisiere
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTarifCroisiere()
    {
        return $this->tarifCroisiere;
    }
}

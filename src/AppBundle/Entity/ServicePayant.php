<?php

// src/AppBundle/Entity/ServicePayant.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity
 * @ORM\Table(name="servicepayant")
 */
class ServicePayant {

    use ORMBehaviors\Translatable\Translatable;
        
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
    * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Prestation", cascade={"persist"})
    */
    protected $prestation;
    
    /**
    * @ORM\Column(type="string", length=200, nullable=true)
    */
    protected $categorie;
    
    /**
    * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Bateau", cascade={"persist"})
    */
    protected $bateau;
    
    
    /**
    * @ORM\Column(type="string", length=200, nullable=true)
    */
    protected $fraisSupplementaires;
    
        /**
    * @ORM\Column(type="string", length=200, nullable=true)
    */
    protected $devise;
    
    
    /**
     * @ORM\Column(type="boolean")
     */
    protected $published;
    
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

    /**
     * Set published
     *
     * @param boolean $published
     * @return Destination
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
     * Set miniature
     *
     * @param string miniature
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
        return null === $this->miniature
        ? null
        : $this->getUploadDir().'/'.$this->miniature;
    }
    
    protected function getUploadDir()
    {
        return '/uploads/servicepayant';
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
        
        // On récupère la taille de l'image source
        $largeur_source = imagesx($source);        
        $hauteur_source = imagesy($source);
        
        // On redimensionne tout !
        imagecopyresampled($destination, $source, 0, 0, 0, 0, $width, $height, $largeur_source, $hauteur_source);
        $fct($destination, $this->getUploadRootDir() . '/' . $file->getClientOriginalName());
        

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
         return $this->getName() ?: "Nouveau service payant";
    }
   

    /**
     * Set categorie
     *
     * @param string $categorie
     * @return InclusPrix
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return string 
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Set prestation
     *
     * @param \AppBundle\Entity\Prestation $prestation
     * @return InclusPrix
     */
    public function setPrestation(\AppBundle\Entity\Prestation $prestation = null)
    {
        $this->prestation = $prestation;

        return $this;
    }

    /**
     * Get prestation
     *
     * @return \AppBundle\Entity\Prestation 
     */
    public function getPrestation()
    {
        return $this->prestation;
    }

    /**
     * Set fraisSupplémentaires
     *
     * @param string $fraisSupplementaires
     * @return ServicePayant
     */
    public function setFraisSupplémentaires($fraisSupplementaires)
    {
        $this->fraisSupplementaires = $fraisSupplementaires;

        return $this;
    }

    /**
     * Get fraisSupplémentaires
     *
     * @return string 
     */
    public function getFraisSupplementaires()
    {
        return $this->fraisSupplementaires;
    }

    /**
     * Set bateau
     *
     * @param \AppBundle\Entity\Bateau $bateau
     * @return ServicePayant
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
     * Set fraisSupplementaires
     *
     * @param string $fraisSupplementaires
     * @return ServicePayant
     */
    public function setFraisSupplementaires($fraisSupplementaires)
    {
        $this->fraisSupplementaires = $fraisSupplementaires;

        return $this;
    }

    /**
     * Set devise
     *
     * @param string $devise
     * @return ServicePayant
     */
    public function setDevise($devise)
    {
        $this->devise = $devise;

        return $this;
    }

    /**
     * Get devise
     *
     * @return string 
     */
    public function getDevise()
    {
        return $this->devise;
    }
}

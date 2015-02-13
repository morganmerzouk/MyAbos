<?php

// src/AppBundle/Entity/Bateau.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity
 * @ORM\Table(name="bateau")
 */
class Bateau {

    use ORMBehaviors\Translatable\Translatable;
        
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
        
    /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Skipper", cascade={"persist"})
   */
    protected $skipper;
    
    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $type;
    
    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $miniature;
    
    protected $miniatureFile;
    
    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $photo1;
    
    protected $photo1File;
    
    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $photo2;
    
    protected $photo2File;    
    
    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $photo3;
    
    protected $photo3File;   
     
    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $photo4;
    
    protected $photo4File; 
       
    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $photo5;
    
    protected $photo5File;
    
    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $photoVoile;
    
    protected $photoVoileFile;
    
    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $photoMouillage;
    
    protected $photoMouillageFile;
    
    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $photoCockpit;
    
    protected $photoCockpitFile;
    
    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $photoCarre;
    
    protected $photoCarreFile;
    
    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $photoCabine;
    
    protected $photoCabineFile;
    
                
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $nbCabine;
    
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $nbDouche;
    
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $nbEquipier;
    
    /**
     * @ORM\Column(type="boolean")
     */
    protected $published;
    
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
     * Set skipper
     *
     * @param \AppBundle\Entity\Skipper $skipper
     * @return Skipper
     */
    public function setSkipper(\AppBundle\Entity\Skipper $skipper)
    {
        $this->skipper = $skipper;

        return $this;
    }
    
    /**
     * Get portDepart
     *
     * @return PortDepart 
     */
    public function getSkipper()
    {
        return $this->skipper;
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
     * Sets photoVoileFile.
     *
     * @param UploadedFile $photoVoileFile
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
     * Sets photoVoileFile.
     *
     * @param UploadedFile $photoVoileFile
     */
    public function setPhotoVoileFile(UploadedFile $photoVoileFile = null)
    {
        $this->photoVoileFile = $photoVoileFile;
    }
    
    /**
     * Get photoVoileFile.
     *
     * @return UploadedFile
     */
    public function getPhotoVoileFile()
    {
        return $this->photoVoileFile;
    }
    
    /**
     * Sets photoMouillageFile.
     *
     * @param UploadedFile $photoMouillageFile
     */
    public function setPhotoMouillageFile(UploadedFile $photoMouillageFile = null)
    {
        $this->photoMouillageFile = $photoMouillageFile;
    }
    
    /**
     * Get photoMouillageFile.
     *
     * @return UploadedFile
     */
    public function getPhotoMouillageFile()
    {
        return $this->photoMouillageFile;
    }
    
    /**
     * Sets photoCockpitFile.
     *
     * @param UploadedFile $photoCockpitFile
     */
    public function setPhotoCockpitFile(UploadedFile $photoCockpitFile = null)
    {
        $this->photoCockpitFile = $photoCockpitFile;
    }
    
    /**
     * Get photoCockpitFile.
     *
     * @return UploadedFile
     */
    public function getPhotoCockpitFile()
    {
        return $this->photoCockpitFile;
    }
    
    /**
     * Sets photoCarreFile.
     *
     * @param UploadedFile $photoCarreFile
     */
    public function setPhotoCarreFile(UploadedFile $photoCarreFile = null)
    {
        $this->photoCarreFile = $photoCarreFile;
    }
    
    /**
     * Get photoCarreFile.
     *
     * @return UploadedFile
     */
    public function getPhotoCarreFile()
    {
        return $this->photoCarreFile;
    }
    
    /**
     * Sets photoCabineFile.
     *
     * @param UploadedFile $photoCabineFile
     */
    public function setPhotoCabineFile(UploadedFile $photoCabineFile = null)
    {
        $this->photoCabineFile = $photoCabineFile;
    }
    
    /**
     * Get photoCabineFile.
     *
     * @return UploadedFile
     */
    public function getPhotoCabineFile()
    {
        return $this->photoCabineFile;
    }
    
    public function getMiniatureWebPath()
    {
        return null === $this->miniature
        ? null
        : $this->getUploadDir().'/'.$this->miniature;
    }
    
    public function getPhotoVoileWebPath()
    {
        return null === $this->photoVoile
        ? null
        : $this->getUploadDir().'/'.$this->photoVoile;
    }
    
    public function getPhotoMouillageWebPath()
    {
        return null === $this->photoMouillage
        ? null
        : $this->getUploadDir().'/'.$this->photoMouillage;
    }
    
    public function getPhotoCockpitWebPath()
    {
        return null === $this->photoCockpit
        ? null
        : $this->getUploadDir().'/'.$this->photoCockpit;
    }
    
    public function getPhotoCarreWebPath()
    {
        return null === $this->photoCarre
        ? null
        : $this->getUploadDir().'/'.$this->photoCarre;
    }
    
    public function getPhotoCabineWebPath()
    {
        return null === $this->photoCabine
        ? null
        : $this->getUploadDir().'/'.$this->photoCabine;
    }
    
    
    protected function getUploadDir()
    {
        return '/uploads/bateau';
    }
        
    protected function getUploadRootDir(){
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }
        
    public function upload($basepath)
    {
        $this->uploadImage($this->miniatureFile, "setMiniature", 200, 200);
        $this->uploadImage($this->photoVoileFile, "setPhotoVoile", 300, 300);
        $this->uploadImage($this->photoMouillageFile, "setPhotoMouillage", 300, 300);
        $this->uploadImage($this->photoCockpitFile, "setPhotoCockpit", 300, 300);
        $this->uploadImage($this->photoCarreFile, "setPhotoCarre", 300, 300);
        $this->uploadImage($this->photoCabineFile, "setPhotoCabine", 300, 300);
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
    
    /**
     * Set photoVoile
     *
     * @param string $photoVoile
     * @return Bateau
     */
    public function setPhotoVoile($photoVoile)
    {
        $this->photoVoile = $photoVoile;

        return $this;
    }

    /**
     * Get photoVoile
     *
     * @return string 
     */
    public function getPhotoVoile()
    {
        return $this->photoVoile;
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

    public function __toString(){
         return $this->getName() ?: "Nouveau bateau";
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Bateau
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set miniature
     *
     * @param string $miniature
     * @return Bateau
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
     * Set photoMouillage
     *
     * @param string $photoMouillage
     * @return Bateau
     */
    public function setPhotoMouillage($photoMouillage)
    {
        $this->photoMouillage = $photoMouillage;

        return $this;
    }

    /**
     * Get photoMouillage
     *
     * @return string 
     */
    public function getPhotoMouillage()
    {
        return $this->photoMouillage;
    }

    /**
     * Set photoCockpit
     *
     * @param string $photoCockpit
     * @return Bateau
     */
    public function setPhotoCockpit($photoCockpit)
    {
        $this->photoCockpit = $photoCockpit;

        return $this;
    }

    /**
     * Get photoCockpit
     *
     * @return string 
     */
    public function getPhotoCockpit()
    {
        return $this->photoCockpit;
    }

    /**
     * Set photoCarre
     *
     * @param string $photoCarre
     * @return Bateau
     */
    public function setPhotoCarre($photoCarre)
    {
        $this->photoCarre = $photoCarre;

        return $this;
    }

    /**
     * Get photoCarre
     *
     * @return string 
     */
    public function getPhotoCarre()
    {
        return $this->photoCarre;
    }

    /**
     * Set photoCabine
     *
     * @param string $photoCabine
     * @return Bateau
     */
    public function setPhotoCabine($photoCabine)
    {
        $this->photoCabine = $photoCabine;

        return $this;
    }

    /**
     * Get photoCabine
     *
     * @return string 
     */
    public function getPhotoCabine()
    {
        return $this->photoCabine;
    }

    /**
     * Set photo1
     *
     * @param string $photo1
     * @return Bateau
     */
    public function setPhoto1($photo1)
    {
        $this->photo1 = $photo1;

        return $this;
    }

    /**
     * Get photo1
     *
     * @return string 
     */
    public function getPhoto1()
    {
        return $this->photo1;
    }

    /**
     * Set photo2
     *
     * @param string $photo2
     * @return Bateau
     */
    public function setPhoto2($photo2)
    {
        $this->photo2 = $photo2;

        return $this;
    }

    /**
     * Get photo2
     *
     * @return string 
     */
    public function getPhoto2()
    {
        return $this->photo2;
    }

    /**
     * Set photo3
     *
     * @param string $photo3
     * @return Bateau
     */
    public function setPhoto3($photo3)
    {
        $this->photo3 = $photo3;

        return $this;
    }

    /**
     * Get photo3
     *
     * @return string 
     */
    public function getPhoto3()
    {
        return $this->photo3;
    }

    /**
     * Set photo4
     *
     * @param string $photo4
     * @return Bateau
     */
    public function setPhoto4($photo4)
    {
        $this->photo4 = $photo4;

        return $this;
    }

    /**
     * Get photo4
     *
     * @return string 
     */
    public function getPhoto4()
    {
        return $this->photo4;
    }

    /**
     * Set photo5
     *
     * @param string $photo5
     * @return Bateau
     */
    public function setPhoto5($photo5)
    {
        $this->photo5 = $photo5;

        return $this;
    }

    /**
     * Get photo5
     *
     * @return string 
     */
    public function getPhoto5()
    {
        return $this->photo5;
    }

    /**
     * Set nbCabine
     *
     * @param integer $nbCabine
     * @return Bateau
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
     * Set nbDouche
     *
     * @param integer $nbDouche
     * @return Bateau
     */
    public function setNbDouche($nbDouche)
    {
        $this->nbDouche = $nbDouche;

        return $this;
    }

    /**
     * Get nbDouche
     *
     * @return integer 
     */
    public function getNbDouche()
    {
        return $this->nbDouche;
    }

    /**
     * Set nbEquipier
     *
     * @param integer $nbEquipier
     * @return Bateau
     */
    public function setNbEquipier($nbEquipier)
    {
        $this->nbEquipier = $nbEquipier;

        return $this;
    }

    /**
     * Get nbEquipier
     *
     * @return integer 
     */
    public function getNbEquipier()
    {
        return $this->nbEquipier;
    }
}

<?php

// src/AppBundle/Entity/Bateau.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use AppBundle\Entity\InclusPrix;

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
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $longueur;
    
    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $largeur;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $tirantdeau;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $surfaceGrandVoile;
    
    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $moteur;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $reservoirCarburant;
    
    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $reservoirEau;
    
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
     * @ORM\OneToOne(targetEntity="InclusPrix")
     */
    protected $inclusPrixEquipage;
        
    /**
     * @ORM\OneToOne(targetEntity="InclusPrix")
     */
    protected $inclusPrixAvitaillement;
    
    /**
     * @ORM\ManyToMany(targetEntity="InclusPrix")
     * @ORM\JoinTable(name="bateau_inclusprix_fraisvoyage")
     */
    protected $inclusPrixFraisVoyage;
    
    /**
     * @ORM\ManyToMany(targetEntity="InclusPrix")
     * @ORM\JoinTable(name="bateau_inclusprix_autreservices")
     */
    protected $inclusPrixAutresServices;
    /**
     * @ORM\ManyToMany(targetEntity="InclusPrix")
     * @ORM\JoinTable(name="bateau_inclusprix_equipement")
     */
    protected $inclusPrixEquipement;
    /**
     * @ORM\ManyToMany(targetEntity="InclusPrix")
     * @ORM\JoinTable(name="bateau_inclusprix_activite")
     */
    protected $inclusPrixActivite;
    /**
     * @ORM\ManyToMany(targetEntity="InclusPrix")
     * @ORM\JoinTable(name="bateau_inclusprix_cours")
     */
    protected $inclusPrixCours;
    
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
     * Set name
     *
     * @param string $name
     * @return Bateau
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }
    
    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Set longueur
     *
     * @param string $longueur
     * @return Bateau
     */
    public function setLongueur($longueur)
    {
        $this->longueur = $longueur;
    
        return $this;
    }
    
    /**
     * Get longueur
     *
     * @return string
     */
    public function getLongueur()
    {
        return $this->longueur;
    }
    
    /**
     * Set largeur
     *
     * @param string $largeur
     * @return Bateau
     */
    public function setLargeur($largeur)
    {
        $this->largeur = $largeur;
    
        return $this;
    }
    
    /**
     * Get largeur
     *
     * @return string
     */
    public function getLargeur()
    {
        return $this->largeur;
    }
    
    /**
     * Set moteur
     *
     * @param string $moteur
     * @return Bateau
     */
    public function setMoteur($moteur)
    {
        $this->moteur = $moteur;
    
        return $this;
    }
    
    /**
     * Get moteur
     *
     * @return string
     */
    public function getMoteur()
    {
        return $this->moteur;
    }
    
    /**
     * Set published
     *
     * @param boolean $published
     * @return Bateau
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
        
        // On récupère la taille de l'image source
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

    /**
     * Set tirantdeau
     *
     * @param string $tirantdeau
     * @return Bateau
     */
    public function setTirantdeau($tirantdeau)
    {
        $this->tirantdeau = $tirantdeau;
    }
    
    /**
     * Get tirantdeau
     *
     * @return string 
     */
    public function getTirantdeau()
    {
        return $this->tirantdeau;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->inclusPrixFraisVoyage = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add inclusPrixFraisVoyage
     *
     * @param \AppBundle\Entity\InclusPrix $inclusPrixFraisVoyage
     * @return Bateau
     */
    public function addInclusPrixFraisVoyage(\AppBundle\Entity\InclusPrix $inclusPrixFraisVoyage)
    {
        $this->inclusPrixFraisVoyage[] = $inclusPrixFraisVoyage;

        return $this;
    }

    /**
     * Remove inclusPrixFraisVoyage
     *
     * @param \AppBundle\Entity\InclusPrix $inclusPrixFraisVoyage
     */
    public function removeInclusPrixFraisVoyage(\AppBundle\Entity\InclusPrix $inclusPrixFraisVoyage)
    {
        $this->inclusPrixFraisVoyage->removeElement($inclusPrixFraisVoyage);
    }

    /**
     * Get inclusPrixFraisVoyage
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getInclusPrixFraisVoyage()
    {
        return $this->inclusPrixFraisVoyage;
    }

    /**
     * Set inclusPrixAvitaillement
     *
     * @param \AppBundle\Entity\InclusPrix $inclusPrixAvitaillement
     * @return Bateau
     */
    public function setInclusPrixAvitaillement(\AppBundle\Entity\InclusPrix $inclusPrixAvitaillement = null)
    {
        $this->inclusPrixAvitaillement = $inclusPrixAvitaillement;

        return $this;
    }

    /**
     * Get inclusPrixAvitaillement
     *
     * @return \AppBundle\Entity\InclusPrix 
     */
    public function getInclusPrixAvitaillement()
    {
        return $this->inclusPrixAvitaillement;
    }


    /**
     * Set surfaceGrandVoile
     *
     * @param string $surfaceGrandVoile
     * @return Bateau
     */
    public function setSurfaceGrandVoile($surfaceGrandVoile)
    {
        $this->surfaceGrandVoile = $surfaceGrandVoile;

        return $this;
    }

    /**
     * Get surfaceGrandVoile
     *
     * @return string 
     */
    public function getSurfaceGrandVoile()
    {
        return $this->surfaceGrandVoile;
    }

    /**
     * Set reservoirCarburant
     *
     * @param string $reservoirCarburant
     * @return Bateau
     */
    public function setReservoirCarburant($reservoirCarburant)
    {
        $this->reservoirCarburant = $reservoirCarburant;

        return $this;
    }

    /**
     * Get reservoirCarburant
     *
     * @return string 
     */
    public function getReservoirCarburant()
    {
        return $this->reservoirCarburant;
    }

    /**
     * Set reservoirEau
     *
     * @param string $reservoirEau
     * @return Bateau
     */
    public function setReservoirEau($reservoirEau)
    {
        $this->reservoirEau = $reservoirEau;

        return $this;
    }

    /**
     * Get reservoirEau
     *
     * @return string 
     */
    public function getReservoirEau()
    {
        return $this->reservoirEau;
    }

    /**
     * Set inclusPrixEquipage
     *
     * @param \AppBundle\Entity\InclusPrix $inclusPrixEquipage
     * @return Bateau
     */
    public function setInclusPrixEquipage(\AppBundle\Entity\InclusPrix $inclusPrixEquipage = null)
    {
        $this->inclusPrixEquipage = $inclusPrixEquipage;

        return $this;
    }

    /**
     * Get inclusPrixEquipage
     *
     * @return \AppBundle\Entity\InclusPrix 
     */
    public function getInclusPrixEquipage()
    {
        return $this->inclusPrixEquipage;
    }

    /**
     * Add inclusPrixAutresServices
     *
     * @param \AppBundle\Entity\InclusPrix $inclusPrixAutresServices
     * @return Bateau
     */
    public function addInclusPrixAutresService(\AppBundle\Entity\InclusPrix $inclusPrixAutresServices)
    {
        $this->inclusPrixAutresServices[] = $inclusPrixAutresServices;

        return $this;
    }

    /**
     * Remove inclusPrixAutresServices
     *
     * @param \AppBundle\Entity\InclusPrix $inclusPrixAutresServices
     */
    public function removeInclusPrixAutresService(\AppBundle\Entity\InclusPrix $inclusPrixAutresServices)
    {
        $this->inclusPrixAutresServices->removeElement($inclusPrixAutresServices);
    }

    /**
     * Get inclusPrixAutresServices
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getInclusPrixAutresServices()
    {
        return $this->inclusPrixAutresServices;
    }

    /**
     * Add inclusPrixEquipement
     *
     * @param \AppBundle\Entity\InclusPrix $inclusPrixEquipement
     * @return Bateau
     */
    public function addInclusPrixEquipement(\AppBundle\Entity\InclusPrix $inclusPrixEquipement)
    {
        $this->inclusPrixEquipement[] = $inclusPrixEquipement;

        return $this;
    }

    /**
     * Remove inclusPrixEquipement
     *
     * @param \AppBundle\Entity\InclusPrix $inclusPrixEquipement
     */
    public function removeInclusPrixEquipement(\AppBundle\Entity\InclusPrix $inclusPrixEquipement)
    {
        $this->inclusPrixEquipement->removeElement($inclusPrixEquipement);
    }

    /**
     * Get inclusPrixEquipement
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getInclusPrixEquipement()
    {
        return $this->inclusPrixEquipement;
    }

    /**
     * Add inclusPrixActivite
     *
     * @param \AppBundle\Entity\InclusPrix $inclusPrixActivite
     * @return Bateau
     */
    public function addInclusPrixActivite(\AppBundle\Entity\InclusPrix $inclusPrixActivite)
    {
        $this->inclusPrixActivite[] = $inclusPrixActivite;

        return $this;
    }

    /**
     * Remove inclusPrixActivite
     *
     * @param \AppBundle\Entity\InclusPrix $inclusPrixActivite
     */
    public function removeInclusPrixActivite(\AppBundle\Entity\InclusPrix $inclusPrixActivite)
    {
        $this->inclusPrixActivite->removeElement($inclusPrixActivite);
    }

    /**
     * Get inclusPrixActivite
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getInclusPrixActivite()
    {
        return $this->inclusPrixActivite;
    }

    /**
     * Add inclusPrixCours
     *
     * @param \AppBundle\Entity\InclusPrix $inclusPrixCours
     * @return Bateau
     */
    public function addInclusPrixCour(\AppBundle\Entity\InclusPrix $inclusPrixCours)
    {
        $this->inclusPrixCours[] = $inclusPrixCours;

        return $this;
    }

    /**
     * Remove inclusPrixCours
     *
     * @param \AppBundle\Entity\InclusPrix $inclusPrixCours
     */
    public function removeInclusPrixCour(\AppBundle\Entity\InclusPrix $inclusPrixCours)
    {
        $this->inclusPrixCours->removeElement($inclusPrixCours);
    }

    /**
     * Get inclusPrixCours
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getInclusPrixCours()
    {
        return $this->inclusPrixCours;
    }
}

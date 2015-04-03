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
class Bateau
{
    
    use ORMBehaviors\Translatable\Translatable;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="DateNonDisponibilite")
     */
    protected $dateNonDisponibilite;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $name;

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
    protected $nbCouchage;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $nbLitSimple;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $nbLitDouble;

    /**
     * @ORM\OneToOne(targetEntity="InclusPrix")
     */
    protected $inclusPrixEquipage;

    /**
     * @ORM\ManyToMany(targetEntity="InclusPrix")
     * @ORM\JoinTable(name="bateau_inclusprix_avitaillement")
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    
    // Need this method for the admin list template and front
    public function getDescription()
    {
        return $this->translate()->getDescription();
    }

    public function getLongueur()
    {
        return $this->translate()->getLongueur();
    }

    public function getLargeur()
    {
        return $this->translate()->getLargeur();
    }

    public function getMoteur()
    {
        return $this->translate()->getMoteur();
    }

    public function getTirantdeau()
    {
        return $this->translate()->getTirantdeau();
    }

    public function getSurfaceGrandVoile()
    {
        return $this->translate()->getSurfaceGrandVoile();
    }

    public function getReservoirCarburant()
    {
        return $this->translate()->getReservoirCarburant();
    }

    public function getReservoirEau()
    {
        return $this->translate()->getReservoirEau();
    }

    public function getEquipementCuisine()
    {
        return $this->translate()->getEquipementCuisine();
    }

    public function getLoisir()
    {
        return $this->translate()->getLoisir();
    }

    public function getEnergie()
    {
        return $this->translate()->getEnergie();
    }

    public function getDinghy()
    {
        return $this->translate()->getDinghy();
    }

    public function getJouet()
    {
        return $this->translate()->getJouet();
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
        return null === $this->miniature ? null : $this->getUploadDir() . '/miniature/' . $this->miniature;
    }

    public function getPhotoVoileWebPath()
    {
        return null === $this->photoVoile ? null : $this->getUploadDir() . '/' . $this->photoVoile;
    }

    public function getPhotoMouillageWebPath()
    {
        return null === $this->photoMouillage ? null : $this->getUploadDir() . '/' . $this->photoMouillage;
    }

    public function getPhotoCockpitWebPath()
    {
        return null === $this->photoCockpit ? null : $this->getUploadDir() . '/' . $this->photoCockpit;
    }

    public function getPhotoCarreWebPath()
    {
        return null === $this->photoCarre ? null : $this->getUploadDir() . '/' . $this->photoCarre;
    }

    public function getPhotoCabineWebPath()
    {
        return null === $this->photoCabine ? null : $this->getUploadDir() . '/' . $this->photoCabine;
    }

    protected function getUploadDir()
    {
        return '/uploads/bateau';
    }

    protected function getUploadRootDir()
    {
        return __DIR__ . '/../../../web/' . $this->getUploadDir();
    }

    public function upload($basepath)
    {
        $this->uploadImage($this->miniatureFile, "setMiniature");
        $this->uploadImage($this->photoVoileFile, "setPhotoVoile");
        $this->uploadImage($this->photoMouillageFile, "setPhotoMouillage");
        $this->uploadImage($this->photoCockpitFile, "setPhotoCockpit");
        $this->uploadImage($this->photoCarreFile, "setPhotoCarre");
        $this->uploadImage($this->photoCabineFile, "setPhotoCabine");
    }

    public function uploadImage($file, $fctName)
    {
        if (null === $file) {
            return;
        }
        
        if ($fctName == "setMiniature") {
            $file->move($this->getUploadRootDir() . '/miniature/', $file->getClientOriginalName());
        } else {
            $file->move($this->getUploadRootDir() . '/', $file->getClientOriginalName());
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

    public function __toString()
    {
        return $this->getName() ?  : "Nouveau bateau";
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
     * Add inclusPrixAvitaillement
     *
     * @param \AppBundle\Entity\InclusPrix $inclusPrixAvitaillement            
     * @return Bateau
     */
    public function addInclusPrixAvitaillement(\AppBundle\Entity\InclusPrix $inclusPrixAvitaillement)
    {
        $this->inclusPrixAvitaillement[] = $inclusPrixAvitaillement;
        
        return $this;
    }

    /**
     * Remove inclusPrixAvitaillement
     *
     * @param \AppBundle\Entity\InclusPrix $inclusPrixAvitaillement            
     */
    public function removeInclusPrixAvitaillement(\AppBundle\Entity\InclusPrix $inclusPrixAvitaillement)
    {
        $this->inclusPrixAvitaillement->removeElement($inclusPrixAvitaillement);
    }

    /**
     * Get inclusPrixFraisVoyage
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInclusPrixAvitaillement()
    {
        return $this->inclusPrixAvitaillement;
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

    /**
     * Add dateNonDisponibilite
     *
     * @param \AppBundle\Entity\DateNonDisponibilite $dateNonDisponibilite            
     * @return Bateau
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
     * Get dateNonDisponibilite
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDateNonDisponibilite()
    {
        return $this->dateNonDisponibilite;
    }

    /**
     * Set nbCouchage
     *
     * @param integer $nbCouchage            
     * @return Bateau
     */
    public function setNbCouchage($nbCouchage)
    {
        $this->nbCouchage = $nbCouchage;
        
        return $this;
    }

    /**
     * Get nbCouchage
     *
     * @return integer
     */
    public function getNbCouchage()
    {
        return $this->nbCouchage;
    }

    /**
     * Set nbLitSimple
     *
     * @param integer $nbLitSimple            
     * @return Bateau
     */
    public function setNbLitSimple($nbLitSimple)
    {
        $this->nbLitSimple = $nbLitSimple;
        
        return $this;
    }

    /**
     * Get nbLitSimple
     *
     * @return integer
     */
    public function getNbLitSimple()
    {
        return $this->nbLitSimple;
    }

    /**
     * Set nbLitDouble
     *
     * @param integer $nbLitDouble            
     * @return Bateau
     */
    public function setNbLitDouble($nbLitDouble)
    {
        $this->nbLitDouble = $nbLitDouble;
        
        return $this;
    }

    /**
     * Get nbLitDouble
     *
     * @return integer
     */
    public function getNbLitDouble()
    {
        return $this->nbLitDouble;
    }
}
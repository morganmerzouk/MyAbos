<?php

// src/App/MainBundle/Entity/Provider.php
namespace App\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity
 * @ORM\Table(name="provider")
 */
class Provider
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     *
     * @var Category $category
     *     
     *      @ORM\ManyToOne(targetEntity="Category", inversedBy="providers", cascade={"persist", "merge"})
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $address;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $miniature;

    protected $miniatureFile;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $actif = false;

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
     * toString
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
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
        if ($miniatureFile instanceof UploadedFile)
            $this->upload();
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
        return null === $this->miniature ? null : $this->getUploadDir() . '/' . $this->miniature;
    }

    protected function getUploadDir()
    {
        return '/uploads/provider';
    }

    protected function getUploadRootDir()
    {
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }

    public function upload()
    {
        $this->uploadImage($this->miniatureFile, "setMiniature");
    }

    public function uploadImage($file, $fctName)
    {
        if (null === $file) {
            return;
        }
        if ($fctName == "setMiniature") {
            $file->move($this->getUploadRootDir() . '/', $file->getClientOriginalName());
        }
        
        // set the path property to the filename where you'ved saved the file
        $this->$fctName($file->getClientOriginalName());
        // clean up the file property as you won't need it anymore
        $file = null;
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
     * Set actif
     *
     * @param boolean $actif            
     * @return Bateau
     */
    public function setActif($actif)
    {
        $this->actif = $actif;
        
        return $this;
    }

    /**
     * Get actif
     *
     * @return boolean
     */
    public function getActif()
    {
        return $this->actif;
    }

    /**
     * Constructor
     */
    public function __construct()
    {}

    /**
     * Set adress
     *
     * @param string $adress            
     * @return Provider
     */
    public function setAdress($adress)
    {
        $this->adress = $adress;
        
        return $this;
    }

    /**
     * Get adress
     *
     * @return string
     */
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * Add category
     *
     * @param \App\MainBundle\Entity\Category $category            
     * @return Provider
     */
    public function addCategory(\App\MainBundle\Entity\Category $category)
    {
        $this->category[] = $category;
        
        return $this;
    }

    /**
     * Remove category
     *
     * @param \App\MainBundle\Entity\Category $category            
     */
    public function removeCategory(\App\MainBundle\Entity\Category $category)
    {
        $this->category->removeElement($category);
    }

    /**
     * Get category
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set address
     *
     * @param string $address            
     * @return Provider
     */
    public function setAddress($address)
    {
        $this->address = $address;
        
        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set category
     *
     * @param \App\MainBundle\Entity\Category $category
     * @return Provider
     */
    public function setCategory(\App\MainBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }
}

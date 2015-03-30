<?php

// src/AppBundle/Entity/InclusPrix.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity
 * @ORM\Table(name="inclusprix")
 */
class InclusPrix
{
    
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
    protected $categorie;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Prestation", cascade={"persist"})
     */
    protected $prestation;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $icone;

    protected $iconeFile;

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
     * Set icone
     *
     * @param
     *            string icone
     * @return InclusPrix
     */
    public function setIcone($icone)
    {
        $this->icone = $icone;
        
        return $this;
    }

    /**
     * Get icone
     *
     * @return string
     */
    public function getIcone()
    {
        return $this->icone;
    }

    /**
     * Sets iconeFile.
     *
     * @param UploadedFile $iconeFile            
     */
    public function setIconeFile(UploadedFile $iconeFile = null)
    {
        $this->iconeFile = $iconeFile;
    }

    /**
     * Get iconeFile.
     *
     * @return UploadedFile
     */
    public function getIconeFile()
    {
        return $this->iconeFile;
    }

    public function getIconeWebPath()
    {
        return null === $this->icone ? null : $this->getUploadDir() . '/' . $this->icone;
    }

    protected function getUploadDir()
    {
        return '/uploads/inclusprix';
    }

    protected function getUploadRootDir()
    {
        return __DIR__ . '/../../../web/' . $this->getUploadDir();
    }

    public function upload($basepath)
    {
        $this->uploadImage($this->iconeFile, "setIcone", 35, 35);
    }

    public function uploadImage($file, $fctName, $width, $height)
    {
        if (null === $file) {
            return;
        }
        $destination = imagecreatetruecolor($width, $height);
        
        $extension = $file->getClientOriginalExtension();
        switch (strtolower($extension)) {
            case "png":
                $source = imagecreatefrompng($file);
                imagealphablending($destination, false);
                $colorTransparent = imagecolorallocatealpha($destination, 0, 0, 0, 0x7fff0000);
                imagefill($destination, 0, 0, $colorTransparent);
                imagesavealpha($destination, true);
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
    public function getName()
    {
        return $this->translate()->getName();
    }
    
    // Work even the precedent method not here, the proxy call work fine.
    public function __toString()
    {
        return $this->getName() ?  : "Nouvel inclus prix";
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
     * Constructor
     */
    public function __construct()
    {
        $this->prestation = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add prestation
     *
     * @param \AppBundle\Entity\Prestation $prestation            
     * @return InclusPrix
     */
    public function addPrestation(\AppBundle\Entity\Prestation $prestation)
    {
        $this->prestation[] = $prestation;
        
        return $this;
    }

    /**
     * Remove prestation
     *
     * @param \AppBundle\Entity\Prestation $prestation            
     */
    public function removePrestation(\AppBundle\Entity\Prestation $prestation)
    {
        $this->prestation->removeElement($prestation);
    }

    /**
     * Get prestation
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPrestation()
    {
        return $this->prestation;
    }
}

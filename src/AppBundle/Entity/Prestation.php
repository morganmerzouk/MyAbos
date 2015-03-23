<?php

// src/AppBundle/Entity/Prestation.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity
 * @ORM\Table(name="prestation")
 */
class Prestation
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
    protected $icone;

    protected $iconeFile;

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

    public function getDescription()
    {
        return $this->translate()->getDescription();
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
        return null === $this->icone ? null : $this->getUploadDir() . '/icones/' . $this->icone;
    }

    protected function getUploadDir()
    {
        return '/uploads/prestation';
    }

    protected function getUploadRootDir()
    {
        return __DIR__ . '/../../../web/' . $this->getUploadDir();
    }

    public function upload($basepath)
    {
        $this->uploadImage($this->iconeFile, "setIcone", 100, 100);
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
        
        // On r�cup�re la taille de l'image source
        $largeur_source = imagesx($source);
        $hauteur_source = imagesy($source);
        
        // On redimensionne tout !
        imagecopyresampled($destination, $source, 0, 0, 0, 0, $width, $height, $largeur_source, $hauteur_source);
        if ($fctName == "setIcone") {
            $fct($destination, $this->getUploadRootDir() . '/icones/' . $file->getClientOriginalName());
        } else {
            $fct($destination, $this->getUploadRootDir() . '/' . $file->getClientOriginalName());
        }
        
        // set the path property to the filename where you'ved saved the file
        $this->$fctName($file->getClientOriginalName());
        // clean up the file property as you won't need it anymore
        $file = null;
    }

    /**
     * Set icone
     *
     * @param string $icone            
     * @return Prestation
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

    public function __toString()
    {
        return $this->getName() ?  : "Nouvelle prestation";
    }
}

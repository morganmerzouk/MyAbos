<?php

// src/AppBundle/Entity/EnSavoirPlus.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity
 * @ORM\Table(name="ensavoirplus")
 */
class EnSavoirPlus {

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
    protected $image1;
    
    protected $image1File;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $lien1;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $lien2;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $lien3;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $lien4;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $lien5;
            
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
     * Sets image1File.
     *
     * @param UploadedFile $image1File
     */
    public function setImage1File(UploadedFile $image1File = null)
    {
        $this->image1File = $image1File;
    }
    
    /**
     * Get image1File.
     *
     * @return UploadedFile
     */
    public function getImage1File()
    {
        return $this->image1File;
    }
    
     
    /**
     * Sets photo1File.
     *
     * @param UploadedFile $photo1File
     */
    public function setPhoto1File(UploadedFile $photo1File = null)
    {
        $this->photo1File = $photo1File;
    }
    
    /**
     * Get photo1File.
     *
     * @return UploadedFile
     */
    public function getPhoto1File()
    {
        return $this->photo1File;
    }
    
    /**
     * Sets photo2File.
     *
     * @param UploadedFile $photo2File
     */
    public function setPhoto2File(UploadedFile $photo2File = null)
    {
        $this->photo2File = $photo2File;
    }
    
    /**
     * Get photo2File.
     *
     * @return UploadedFile
     */
    public function getPhoto2File()
    {
        return $this->photo2File;
    }
    
    /**
     * Sets photo3File.
     *
     * @param UploadedFile $photo3File
     */
    public function setPhoto3File(UploadedFile $photo3File = null)
    {
        $this->photo3File = $photo3File;
    }
    
    /**
     * Get photo3File.
     *
     * @return UploadedFile
     */
    public function getPhoto3File()
    {
        return $this->photo3File;
    }
    
    /**
     * Sets photo4File.
     *
     * @param UploadedFile $photo4File
     */
    public function setPhoto4File(UploadedFile $photo4File = null)
    {
        $this->photo4File = $photo4File;
    }
    
    /**
     * Get photo4File.
     *
     * @return UploadedFile
     */
    public function getPhoto4File()
    {
        return $this->photo4File;
    }
    
    /**
     * Sets photo5File.
     *
     * @param UploadedFile $photo5File
     */
    public function setPhoto5File(UploadedFile $photo5File = null)
    {
        $this->photo5File = $photo5File;
    }
    
    /**
     * Get photo5File.
     *
     * @return UploadedFile
     */
    public function getPhoto5File()
    {
        return $this->photo5File;
    }
    
    public function getImage1WebPath()
    {
        return null === $this->image1
        ? null
        : $this->getUploadDir().'/'.$this->image1;
    }
    
    public function getPhoto1WebPath()
    {
        return null === $this->photo1
        ? null
        : $this->getUploadDir().'/'.$this->photo1;
    }
    
    public function getPhoto2WebPath()
    {
        return null === $this->photo2
        ? null
        : $this->getUploadDir().'/'.$this->photo2;
    }
    
    public function getPhoto3WebPath()
    {
        return null === $this->photo3
        ? null
        : $this->getUploadDir().'/'.$this->photo3;
    }
    
    public function getPhoto4WebPath()
    {
        return null === $this->photo4
        ? null
        : $this->getUploadDir().'/'.$this->photo4;
    }
    
    public function getPhoto5WebPath()
    {
        return null === $this->photo5
        ? null
        : $this->getUploadDir().'/'.$this->photo5;
    }
    
    
    protected function getUploadDir()
    {
        return '/uploads/ensavoirplus';
    }
        
    protected function getUploadRootDir(){
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }
        
    public function upload($basepath)
    {
        $this->uploadImage($this->image1File, "setImage1", 300, 300);
        $this->uploadImage($this->photo1File, "setPhoto1", 300, 300);
        $this->uploadImage($this->photo2File, "setPhoto2", 300, 300);
        $this->uploadImage($this->photo3File, "setPhoto3", 300, 300);
        $this->uploadImage($this->photo4File, "setPhoto4", 300, 300);
        $this->uploadImage($this->photo5File, "setPhoto5", 300, 300);
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
        if ($fctName == "") {
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
     * Set image1
     *
     * @param string $image1
     * @return EnSavoirPlus
     */
    public function setImage1($image1)
    {
        $this->image1 = $image1;

        return $this;
    }

    /**
     * Get image1
     *
     * @return string 
     */
    public function getImage1()
    {
        return $this->image1;
    }
    
    /**
     * Set photo1
     *
     * @param string $photo1
     * @return Skipper
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
     * @return Skipper
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
     * @return Skipper
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
     * @return Skipper
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
     * @return Skipper
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
         return $this->getName();
    }

    /**
     * Set lien1
     *
     * @param string $lien1
     * @return EnSavoirPlus
     */
    public function setLien1($lien1)
    {
        $this->lien1 = $lien1;

        return $this;
    }

    /**
     * Get lien1
     *
     * @return string 
     */
    public function getLien1()
    {
        return $this->lien1;
    }

    /**
     * Set lien2
     *
     * @param string $lien2
     * @return EnSavoirPlus
     */
    public function setLien2($lien2)
    {
        $this->lien2 = $lien2;

        return $this;
    }

    /**
     * Get lien2
     *
     * @return string 
     */
    public function getLien2()
    {
        return $this->lien2;
    }

    /**
     * Set lien3
     *
     * @param string $lien3
     * @return EnSavoirPlus
     */
    public function setLien3($lien3)
    {
        $this->lien3 = $lien3;

        return $this;
    }

    /**
     * Get lien3
     *
     * @return string 
     */
    public function getLien3()
    {
        return $this->lien3;
    }

    /**
     * Set lien4
     *
     * @param string $lien4
     * @return EnSavoirPlus
     */
    public function setLien4($lien4)
    {
        $this->lien4 = $lien4;

        return $this;
    }

    /**
     * Get lien4
     *
     * @return string 
     */
    public function getLien4()
    {
        return $this->lien4;
    }

    /**
     * Set lien5
     *
     * @param string $lien5
     * @return EnSavoirPlus
     */
    public function setLien5($lien5)
    {
        $this->lien5 = $lien5;

        return $this;
    }

    /**
     * Get lien5
     *
     * @return string 
     */
    public function getLien5()
    {
        return $this->lien5;
    }
}

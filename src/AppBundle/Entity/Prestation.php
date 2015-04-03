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
        $this->uploadImage($this->iconeFile, "setIcone");
    }

    public function uploadImage($file, $fctName)
    {
        if (null === $file) {
            return;
        }
        
        $file->move($this->getUploadRootDir() . '/icones/', $file->getClientOriginalName());
        
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

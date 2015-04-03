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
class ServicePayant
{
    
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
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $tarifApplique;

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
     * @return ServicePayant
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
        return '/uploads/servicepayant';
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
        
        $file->move($this->getUploadRootDir() . '/', $file->getClientOriginalName());
        
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
        return $this->getName() ?  : "Nouveau service payant";
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

    /**
     * Set tarifApplique
     *
     * @param string $tarifApplique            
     * @return ServicePayant
     */
    public function setTarifApplique($tarifApplique)
    {
        $this->tarifApplique = $tarifApplique;
        
        return $this;
    }

    /**
     * Get tarifApplique
     *
     * @return string
     */
    public function getTarifApplique()
    {
        return $this->tarifApplique;
    }
}

<?php

// src/App/MainBundle/Entity/CauseResiliation.php
namespace App\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="cause_resiliation")
 */
class CauseResiliation
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
     *      @ORM\ManyToOne(targetEntity="Category", inversedBy="causeResiliations", cascade={"persist", "merge"})
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $letter;

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
     * Set name
     *
     * @param string $name            
     * @return Contract
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
     * Set category
     *
     * @param \App\MainBundle\Entity\Category $category            
     * @return Contract
     */
    public function setCategory(\App\MainBundle\Entity\Category $category = null)
    {
        $this->category = $category;
        
        return $this;
    }

    /**
     * Get category
     *
     * @return \App\MainBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set letter
     *
     * @param string $letter            
     * @return CauseResiliation
     */
    public function setLetter($letter)
    {
        $this->letter = $letter;
        
        return $this;
    }

    /**
     * Get letter
     *
     * @return string
     */
    public function getLetter()
    {
        return $this->letter;
    }

    /**
     * Set actif
     *
     * @param boolean $actif
     * @return CauseResiliation
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
}

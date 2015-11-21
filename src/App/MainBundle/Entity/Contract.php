<?php

// src/App/MainBundle/Entity/Category.php
namespace App\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity
 * @ORM\Table(name="contract")
 */
class Contract
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     *
     * @var User $user
     *     
     *      @ORM\ManyToOne(targetEntity="User", inversedBy="contracts", cascade={"persist", "merge"})
     */
    private $user;

    /**
     *
     * @var Category $category
     *     
     *      @ORM\ManyToOne(targetEntity="Category", inversedBy="contracts", cascade={"persist", "merge"})
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $provider;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $number;

    /**
     * @ORM\Column(type="date")
     */
    protected $startingDate;

    /**
     * @ORM\Column(type="date")
     */
    protected $endingDate;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $amount;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $amountFrequency;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $withEngagement = false;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $autoRenewal = false;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $engagementLength;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $alertFrequency;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $contract;

    protected $contractFile;

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
     * Sets photoVoileFile.
     *
     * @param UploadedFile $photoVoileFile            
     */
    public function setContractFile(UploadedFile $contractFile = null)
    {
        $this->contractFile = $contractFile;
        if ($contractFile instanceof UploadedFile)
            $this->upload();
    }

    /**
     * Get contractFile.
     *
     * @return UploadedFile
     */
    public function getContractFile()
    {
        return $this->contractFile;
    }

    public function getContractWebPath()
    {
        return null === $this->contract ? null : $this->getUploadDir() . '/' . $this->contract;
    }

    protected function getUploadDir()
    {
        return '/uploads/contract';
    }

    protected function getUploadRootDir()
    {
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }

    public function upload()
    {
        $this->uploadImage($this->contractFile, "setContract");
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

    /**
     * Set contract
     *
     * @param string $contract            
     * @return Contract
     */
    public function setContract($contract)
    {
        $this->contract = $contract;
        
        return $this;
    }

    /**
     * Get contract
     *
     * @return string
     */
    public function getContract()
    {
        return $this->contract;
    }

    /**
     * Set provider
     *
     * @param string $provider            
     * @return Contract
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;
        
        return $this;
    }

    /**
     * Get provider
     *
     * @return string
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * Set number
     *
     * @param string $number            
     * @return Contract
     */
    public function setNumber($number)
    {
        $this->number = $number;
        
        return $this;
    }

    /**
     * Get number
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set startingDate
     *
     * @param \DateTime $startingDate            
     * @return Contract
     */
    public function setStartingDate($startingDate)
    {
        $this->startingDate = \DateTime::createFromFormat("d/m/Y", $startingDate);
        
        return $this;
    }

    /**
     * Get startingDate
     *
     * @return \DateTime
     */
    public function getStartingDate()
    {
        return $this->startingDate;
    }

    /**
     * Set endingDate
     *
     * @param \DateTime $endingDate            
     * @return Contract
     */
    public function setEndingDate($endingDate)
    {
        $this->endingDate = \DateTime::createFromFormat("d/m/Y", $endingDate);
        
        return $this;
    }

    /**
     * Get endingDate
     *
     * @return \DateTime
     */
    public function getEndingDate()
    {
        return $this->endingDate;
    }

    /**
     * Set amount
     *
     * @param string $amount            
     * @return Contract
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        
        return $this;
    }

    /**
     * Get amount
     *
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set amountFrequency
     *
     * @param string $amountFrequency            
     * @return Contract
     */
    public function setAmountFrequency($amountFrequency)
    {
        $this->amountFrequency = $amountFrequency;
        
        return $this;
    }

    /**
     * Get amountFrequency
     *
     * @return string
     */
    public function getAmountFrequency()
    {
        return $this->amountFrequency;
    }

    /**
     * Set withEngagement
     *
     * @param boolean $withEngagement            
     * @return Contract
     */
    public function setWithEngagement($withEngagement)
    {
        $this->withEngagement = $withEngagement;
        
        return $this;
    }

    /**
     * Get withEngagement
     *
     * @return boolean
     */
    public function getWithEngagement()
    {
        return $this->withEngagement;
    }

    /**
     * Set autoRenewal
     *
     * @param boolean $autoRenewal            
     * @return Contract
     */
    public function setAutoRenewal($autoRenewal)
    {
        $this->autoRenewal = $autoRenewal;
        
        return $this;
    }

    /**
     * Get autoRenewal
     *
     * @return boolean
     */
    public function getAutoRenewal()
    {
        return $this->autoRenewal;
    }

    /**
     * Set engagementLength
     *
     * @param string $engagementLength            
     * @return Contract
     */
    public function setEngagementLength($engagementLength)
    {
        $this->engagementLength = $engagementLength;
        
        return $this;
    }

    /**
     * Get engagementLength
     *
     * @return string
     */
    public function getEngagementLength()
    {
        return $this->engagementLength;
    }

    /**
     * Set alertFrequency
     *
     * @param string $alertFrequency            
     * @return Contract
     */
    public function setAlertFrequency($alertFrequency)
    {
        $this->alertFrequency = $alertFrequency;
        
        return $this;
    }

    /**
     * Get alertFrequency
     *
     * @return string
     */
    public function getAlertFrequency()
    {
        return $this->alertFrequency;
    }

    /**
     * Set user
     *
     * @param \App\MainBundle\Entity\User $user            
     * @return Contract
     */
    public function setUser(\App\MainBundle\Entity\User $user = null)
    {
        $this->user = $user;
        
        return $this;
    }

    /**
     * Get user
     *
     * @return \App\MainBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
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
}

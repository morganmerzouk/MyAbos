<?php

// src/AppBundle/Entity/Skipper.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity
 * @ORM\Table(name="skipper")
 */
class Skipper {

    use ORMBehaviors\Translatable\Translatable;
        
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
    * @ORM\Column(type="string", length=100, nullable=true)
    */
    protected $name;
    
    /**
    * @ORM\Column(type="string", length=100, nullable=true)
    */
    protected $email;
    
    /**
    * @ORM\Column(type="text", nullable=true)
    */
    protected $description;
    
    /**
    * @ORM\Column(type="string", length=30, nullable=true)
    */
    protected $yearsSailing;
    
    /**
    * @ORM\Column(type="string", length=30, nullable=true)
    */
    protected $professionalSince;
    
    /**
    * @ORM\Column(type="string", length=30, nullable=true)
    */
    protected $certificationDate;
    
    /**
    * @ORM\Column(type="string", length=30, nullable=true)
    */
    protected $yearsSailingCarribean;
    
    /**
    * @ORM\Column(type="string", length=30, nullable=true)
    */
    protected $yearsKiteSurfing;
    
    /**
    * @ORM\Column(type="string", length=30, nullable=true)
    */
    protected $yearsKiteCruise;
    
    /**
    * @ORM\Column(type="string", length=30, nullable=true)
    */
    protected $kitesurfInstructorSince;
    
    /**
    * @ORM\Column(type="string", length=30, nullable=true)
    */
    protected $kitesurfCertificationDate;
    
    /**
    * @ORM\Column(type="string", length=200, nullable=true)
    */
    protected $languagesSpoken;
        
    /**
    * @ORM\Column(type="string", length=200, nullable=true)
    */
    protected $avatar;
    
    protected $avatarFile;
    
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
     * Set name
     *
     * @param string $name
     * @return Skipper
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
     * Set email
     *
     * @param string $email
     * @return Skipper
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Skipper
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set yearsSailing
     *
     * @param string $yearsSailing
     * @return Skipper
     */
    public function setYearsSailing($yearsSailing)
    {
        $this->yearsSailing = $yearsSailing;

        return $this;
    }

    /**
     * Get yearsSailing
     *
     * @return string 
     */
    public function getYearsSailing()
    {
        return $this->yearsSailing;
    }

    /**
     * Set professionalSince
     *
     * @param string $professionalSince
     * @return Skipper
     */
    public function setProfessionalSince($professionalSince)
    {
        $this->professionalSince = $professionalSince;

        return $this;
    }

    /**
     * Get professionalSince
     *
     * @return string 
     */
    public function getProfessionalSince()
    {
        return $this->professionalSince;
    }

    /**
     * Set certificationDate
     *
     * @param string $certificationDate
     * @return Skipper
     */
    public function setCertificationDate($certificationDate)
    {
        $this->certificationDate = $certificationDate;

        return $this;
    }

    /**
     * Get certificationDate
     *
     * @return string 
     */
    public function getCertificationDate()
    {
        return $this->certificationDate;
    }

    /**
     * Set yearsSailingCarribean
     *
     * @param string $yearsSailingCarribean
     * @return Skipper
     */
    public function setYearsSailingCarribean($yearsSailingCarribean)
    {
        $this->yearsSailingCarribean = $yearsSailingCarribean;

        return $this;
    }

    /**
     * Get yearsSailingCarribean
     *
     * @return string 
     */
    public function getYearsSailingCarribean()
    {
        return $this->yearsSailingCarribean;
    }

    /**
     * Set yearsKiteSurfing
     *
     * @param string $yearsKiteSurfing
     * @return Skipper
     */
    public function setYearsKiteSurfing($yearsKiteSurfing)
    {
        $this->yearsKiteSurfing = $yearsKiteSurfing;

        return $this;
    }

    /**
     * Get yearsKiteSurfing
     *
     * @return string 
     */
    public function getYearsKiteSurfing()
    {
        return $this->yearsKiteSurfing;
    }

    /**
     * Set yearsKiteCruise
     *
     * @param string $yearsKiteCruise
     * @return Skipper
     */
    public function setYearsKiteCruise($yearsKiteCruise)
    {
        $this->yearsKiteCruise = $yearsKiteCruise;

        return $this;
    }

    /**
     * Get yearsKiteCruise
     *
     * @return string 
     */
    public function getYearsKiteCruise()
    {
        return $this->yearsKiteCruise;
    }

    /**
     * Set kitesurfInstructorSince
     *
     * @param string $kitesurfInstructorSince
     * @return Skipper
     */
    public function setKitesurfInstructorSince($kitesurfInstructorSince)
    {
        $this->kitesurfInstructorSince = $kitesurfInstructorSince;

        return $this;
    }

    /**
     * Get kitesurfInstructorSince
     *
     * @return string 
     */
    public function getKitesurfInstructorSince()
    {
        return $this->kitesurfInstructorSince;
    }

    /**
     * Set kitesurfCertificationDate
     *
     * @param string $kitesurfCertificationDate
     * @return Skipper
     */
    public function setKitesurfCertificationDate($kitesurfCertificationDate)
    {
        $this->kitesurfCertificationDate = $kitesurfCertificationDate;

        return $this;
    }

    /**
     * Get kitesurfCertificationDate
     *
     * @return string 
     */
    public function getKitesurfCertificationDate()
    {
        return $this->kitesurfCertificationDate;
    }

    /**
     * Set otherCertifications
     *
     * @param string $otherCertifications
     * @return Skipper
     */
    public function setOtherCertifications($otherCertifications)
    {
        $this->otherCertifications = $otherCertifications;

        return $this;
    }

    /**
     * Get otherCertifications
     *
     * @return string 
     */
    public function getOtherCertifications()
    {
        return $this->otherCertifications;
    }

    /**
     * Set hobbies
     *
     * @param string $hobbies
     * @return Skipper
     */
    public function setHobbies($hobbies)
    {
        $this->hobbies = $hobbies;

        return $this;
    }

    /**
     * Get hobbies
     *
     * @return string 
     */
    public function getHobbies()
    {
        return $this->hobbies;
    }

    /**
     * Set languagesSpoken
     *
     * @param string $languagesSpoken
     * @return Skipper
     */
    public function setLanguagesSpoken($languagesSpoken)
    {
        $this->languagesSpoken = implode(', ',$languagesSpoken);

        return $this;
    }

    /**
     * Get languagesSpoken
     *
     * @return string 
     */
    public function getLanguagesSpoken()
    {
        return explode(', ', $this->languagesSpoken);
    }

    /**
     * Set greatestQualities
     *
     * @param string $greatestQualities
     * @return Skipper
     */
    public function setGreatestQualities($greatestQualities)
    {
        $this->greatestQualities = $greatestQualities;

        return $this;
    }

    /**
     * Get greatestQualities
     *
     * @return string 
     */
    public function getGreatestQualities()
    {
        return $this->greatestQualities;
    }


    /**
     * Set published
     *
     * @param boolean $published
     * @return Skipper
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
     * Set avatar
     *
     * @param string $avatar
     * @return Skipper
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    
        return $this;
    }
    
    /**
     * Get avatar
     *
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }
    
    
    /**
     * Sets avatarFile.
     *
     * @param UploadedFile $avatarFile
     */
    public function setAvatarFile(UploadedFile $avatarFile = null)
    {
        $this->avatarFile = $avatarFile;
    }
    
    /**
     * Get avatarFile.
     *
     * @return UploadedFile
     */
    public function getAvatarFile()
    {
        return $this->avatarFile;
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
    
    public function getAvatarWebPath()
    {
        return null === $this->avatar
        ? null
        : $this->getUploadDir().'/avatar/'.$this->avatar;
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
        return '/uploads/skipper';
    }
    
    protected function getUploadRootDir(){
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }
    
    public function upload($basepath)
    {
        $this->uploadImage($this->avatarFile, "setAvatar", 125, 125);
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
        $destination = imagecreatetruecolor($width, 125);

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
        if ($fctName == "setAvatar") {
            $fct($destination, $this->getUploadRootDir() . '/avatar/' . $file->getClientOriginalName());
        } else {
            $fct($destination, $this->getUploadRootDir() . '/' . $file->getClientOriginalName());
        }

        // set the path property to the filename where you'ved saved the file
        $this->$fctName($file->getClientOriginalName());
        // clean up the file property as you won't need it anymore
        $file = null;
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
    
    public function __toString(){
         return $this->getName() ?: "Nouveau skipper";
    }
}

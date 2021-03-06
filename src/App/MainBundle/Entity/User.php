<?php
namespace App\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Entity\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Util\SecureRandom;

/**
 * Class User
 *
 * @package App\MainBundle\Entity
 *          @ORM\Table(name="fos_user")
 *          @ORM\Entity
 */
class User extends BaseUser
{

    const ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';

    const ROLE_ADMIN = 'ROLE_ADMIN';

    const ROLE_USER = 'ROLE_USER';

    /**
     *
     * @var integer @ORM\Column(name="id", type="integer")
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     *
     * @var @ORM\ManyToMany(targetEntity="Group", inversedBy="users")
     *      @ORM\JoinTable(name="users_groups",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     *      )
     */
    protected $groups;

    /**
     *
     * @var ArrayCollection $contract
     *     
     *      @ORM\OneToMany(targetEntity="Contract", mappedBy="user", cascade={"persist", "remove", "merge"})
     */
    private $contracts;

    /**
     *
     * @var string @ORM\Column(name="facebook_id", type="string", nullable=true)
     */
    protected $facebook_id;

    /**
     *
     * @var string @ORM\Column(name="google_id", type="string", nullable=true)
     */
    protected $google_id;

    /**
     *
     * @var string @ORM\Column(name="twitter_id", type="string", nullable=true)
     */
    protected $twitter_id;

    /**
     *
     * @var @ORM\Column(name="gender", type="string", length=255, nullable=true)
     */
    protected $gender;

    /**
     *
     * @var @ORM\Column(name="firstname", type="string", length=255, nullable=true)
     */
    protected $firstname;

    /**
     *
     * @var @ORM\Column(name="lastname", type="string", length=255, nullable=true)
     */
    protected $lastname;

    /**
     *
     * @var @ORM\Column(name="address", type="text", nullable=true, nullable=true)
     */
    protected $address;

    /**
     *
     * @var @ORM\Column(name="zip_code", type="string", length=255, nullable=true)
     */
    protected $zipCode;

    /**
     *
     * @var @ORM\Column(name="city", type="string", length=255, nullable=true)
     */
    protected $city;

    /**
     *
     * @var @ORM\Column(name="country", type="string", length=255, nullable=true)
     */
    protected $country;

    /**
     *
     * @var @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    protected $phone;

    /**
     * @Assert\File(maxSize="2048k")
     * @Assert\Image(mimeTypesMessage="Please upload a valid image.")
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $avatar;

    protected $avatarFile;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->groups = new ArrayCollection();
    }

    /**
     *
     * @param mixed $gender            
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     *
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     *
     * @param mixed $email            
     */
    public function setEmail($email)
    {
        $this->email = $email;
        $this->username = $email;
    }

    /**
     *
     * @param mixed $firstname            
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     *
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     *
     * @param mixed $lastname            
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     *
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     *
     * @param mixed $address            
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     *
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     *
     * @param mixed $city            
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     *
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     *
     * @param mixed $country            
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     *
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     *
     * @param int $id            
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @param mixed $zipCode            
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
    }

    /**
     *
     * @return mixed
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     *
     * @param mixed $phone            
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     *
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
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

    public function getAvatarWebPath()
    {
        return null === $this->avatar ? null : $this->getUploadDir() . '/avatar/' . $this->avatar;
    }

    protected function getUploadDir()
    {
        return '/uploads/user';
    }

    protected function getUploadRootDir()
    {
        return __DIR__ . '/../../../web/' . $this->getUploadDir();
    }

    public function upload($basepath)
    {
        $this->uploadImage($this->avatarFile, "setAvatar");
    }

    public function uploadImage($file, $fctName)
    {
        if (null === $file) {
            return;
        }
        
        $file->move($this->getUploadRootDir() . '/avatar/', $file->getClientOriginalName());
        
        // set the path property to the filename where you'ved saved the file
        $this->$fctName($file->getClientOriginalName());
        // clean up the file property as you won't need it anymore
        $file = null;
    }

    /**
     *
     * @param
     *            $group
     * @return $this
     */
    public function addGoup($group)
    {
        $this->groups[] = $group;
        $group->setUser($this);
        
        return $this;
    }

    /**
     *
     * @param
     *            $groups
     */
    public function setGroups($groups)
    {
        $this->groups->clear();
        foreach ($groups as $group) {
            $this->addGroup($group);
        }
    }

    /**
     *
     * @return ArrayCollection
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * Add contracts
     *
     * @param \App\MainBundle\Entity\Contract $contracts            
     * @return User
     */
    public function addContract(\App\MainBundle\Entity\Contract $contracts)
    {
        $this->contracts[] = $contracts;
        
        return $this;
    }

    /**
     * Remove contracts
     *
     * @param \App\MainBundle\Entity\Contract $contracts            
     */
    public function removeContract(\App\MainBundle\Entity\Contract $contracts)
    {
        $this->contracts->removeElement($contracts);
    }

    /**
     * Get contracts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getContracts()
    {
        return $this->contracts;
    }

    /**
     * Set facebook_id
     *
     * @param string $facebookId
     * @return User
     */
    public function setFacebookId($facebookId)
    {
        $this->facebook_id = $facebookId;

        return $this;
    }

    /**
     * Get facebook_id
     *
     * @return string 
     */
    public function getFacebookId()
    {
        return $this->facebook_id;
    }

    /**
     * Set google_id
     *
     * @param string $googleId
     * @return User
     */
    public function setGoogleId($googleId)
    {
        $this->google_id = $googleId;

        return $this;
    }

    /**
     * Get google_id
     *
     * @return string 
     */
    public function getGoogleId()
    {
        return $this->google_id;
    }

    /**
     * Set twitter_id
     *
     * @param string $twitterId
     * @return User
     */
    public function setTwitterId($twitterId)
    {
        $this->twitter_id = $twitterId;

        return $this;
    }

    /**
     * Get twitter_id
     *
     * @return string 
     */
    public function getTwitterId()
    {
        return $this->twitter_id;
    }
}

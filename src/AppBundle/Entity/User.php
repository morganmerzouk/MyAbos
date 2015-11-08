<?php
namespace AppBundle\Entity;

use Application\Sonata\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function setEmail($email)
    {
        parent::setEmail($email);
        parent::setUsername($email);
    }

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}

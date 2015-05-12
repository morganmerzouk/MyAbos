<?php
// src/AppBundle/DataFixtures/ORM/UserFixtures.php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UserFixtures extends AbstractFixture implements FixtureInterface, ContainerAwareInterface
{

    /**
     *
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $userManager = $this->container->get('fos_user.user_manager');
        
        $userAdmin = $userManager->createUser();
        $userAdmin->setUsername('mmerzouk');
        $userAdmin->setEmail('morgan.merzouk@gmail.com');
        $userAdmin->setPlainPassword($this->container->getParameter('mdp_morgan'));
        $userAdmin->setEnabled(true);
        $userAdmin->setRoles(array(
            'ROLE_SUPER_ADMIN'
        ));
        
        $manager->persist($userAdmin);
        $manager->flush();
    }
}

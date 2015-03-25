<?php
// src/AppBundle/DataFixtures/ORM/DestinationFixtures.php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\PortDepart;
use Symfony\Component\Yaml\Yaml;

class PortDepartFixtures extends AbstractFixture implements FixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $yml = Yaml::parse(file_get_contents(__DIR__ . "/../portdepart.yml"));
        foreach ($yml as $key => $item) {
            $portDepart = new PortDepart();
            $portDepart->translate('fr')->setName($item['name_fr']);
            $portDepart->translate('en')->setName($item['name_en']);
            $portDepart->setMiniature($item['miniature']);
            
            $manager->persist($portDepart);
            $portDepart->mergeNewTranslations();
            $manager->flush();
        }
    }
}

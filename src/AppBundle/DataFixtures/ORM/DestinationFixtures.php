<?php
// src/AppBundle/DataFixtures/ORM/DestinationFixtures.php

namespace AppBundle\DataFixtures\ORM;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Destination;
use Symfony\Component\Yaml\Yaml;

class DestinationFixtures extends AbstractFixture implements FixtureInterface {
    public function load(ObjectManager $manager)
    {
        $yml = Yaml::parse(file_get_contents(__DIR__ . "/../destination.yml"));
        foreach ($yml as $key => $item) {
            $destination = new Destination();
            $destination->translate('fr')->setName($item['name_fr']);
            $destination->translate('en')->setName($item['name_en']);
            
            $description = explode('--boundary--',addslashes(file_get_contents(__DIR__ . "/../destination/destination".$key.".html")));
            $destination->translate('fr')->setDescription($description[0]);
            $destination->translate('en')->setDescription($description[1]);            
            $destination->setPublished(true);
            
            $manager->persist($destination);
            $destination->mergeNewTranslations();
            $manager->flush();
        }
        
        
    }

}

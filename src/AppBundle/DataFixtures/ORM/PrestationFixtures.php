<?php
// src/AppBundle/DataFixtures/ORM/DestinationFixtures.php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Prestation;
use Symfony\Component\Yaml\Yaml;

class PrestationFixtures implements FixtureInterface {
    public function load(ObjectManager $manager)
    {
        $yml = Yaml::parse(file_get_contents(__DIR__ . "/../prestation.yml"));
        foreach ($yml as $key => $item) {
            $prestation = new Prestation();
            $prestation->translate('fr')->setName($item['name_fr']);
            $prestation->translate('en')->setName($item['name_en']);
            $prestation->translate('fr')->setDescription(addslashes(file_get_contents(__DIR__ . "/../prestation/prestation".$key.".html")));
                        
            $prestation->setPublished(false);
            
            $manager->persist($prestation);
            $prestation->mergeNewTranslations();
            $manager->flush();
        }
        
        
    }

}

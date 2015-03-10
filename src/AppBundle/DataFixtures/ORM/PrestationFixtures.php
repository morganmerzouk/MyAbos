<?php
// src/AppBundle/DataFixtures/ORM/DestinationFixtures.php

namespace AppBundle\DataFixtures\ORM;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Prestation;
use Symfony\Component\Yaml\Yaml;

class PrestationFixtures extends AbstractFixture implements FixtureInterface {
    public function load(ObjectManager $manager)
    {
        $yml = Yaml::parse(file_get_contents(__DIR__ . "/../prestation.yml"));
        foreach ($yml as $key => $item) {
            $prestation = new Prestation();
            $prestation->translate('fr')->setName($item['name_fr']);
            $prestation->translate('en')->setName($item['name_en']);
                         
            $description = explode('--boundary--',addslashes(file_get_contents(__DIR__ . "/../prestation/prestation".$key.".html")));
            $prestation->translate('fr')->setDescription($description[0]);
            $prestation->translate('en')->setDescription($description[1]);          
            $prestation->setPublished(true);
            if(isset($item['icone'])) {
                $prestation->setIcone($item['icone']);
            }
            
            $manager->persist($prestation);
            $prestation->mergeNewTranslations();
            $manager->flush();
        }
        
        
    }

}

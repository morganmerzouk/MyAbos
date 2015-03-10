<?php
// src/AppBundle/DataFixtures/ORM/DestinationFixtures.php

namespace AppBundle\DataFixtures\ORM;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Skipper;
use Symfony\Component\Yaml\Yaml;

class SkipperFixtures extends AbstractFixture implements FixtureInterface {
    public function load(ObjectManager $manager)
    {
        $yml = Yaml::parse(file_get_contents(__DIR__ . "/../skipper.yml"));
        foreach ($yml as $key => $item) {
            $skipper = new Skipper();
            $skipper->setName($item['name']);
                         
            $description = explode('--boundary--',addslashes(file_get_contents(__DIR__ . "/../skipper/skipper".$key.".html")));
            $skipper->translate('fr')->setDescription($description[0]);
            $skipper->translate('en')->setDescription($description[1]); 
            $skipper->setAvatar($item['avatar']);
            $skipper->setPublished(true);
            
            $manager->persist($skipper);
            $skipper->mergeNewTranslations();
            $manager->flush();
        }
        
        
    }

}

<?php
// src/AppBundle/DataFixtures/DestinationFixtures.php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Destination;

class DestinationFixtures implements FixtureInterface {
    public function load(ObjectManager $manager)
    {
        $destination = new Destination();
        
        $destination->translate('fr')->setName('nom');
        $destination->translate('en')->setName('name');
        
        $destination->setPublished(false);
        
        $manager->persist($destination);
        $destination->mergeNewTranslations();
        $manager->flush();
    }

}

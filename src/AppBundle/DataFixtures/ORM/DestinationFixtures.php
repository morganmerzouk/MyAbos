<?php
// src/AppBundle/DataFixtures/DestinationFixtures.php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Destination;

class DestinationFixtures implements FixtureInterface {
    public function load(ObjectManager $manager)
    {
        $destinations = array();
        
        $destination1 = new Destination();        
        $destination1->translate('fr')->setName('Anguilla');
        $destination1->translate('en')->setName('Anguilla');
        
        $destination1->setPublished(true);
        array_push($destinations, $destination1);
        
        $destination2 = new Destination();        
        $destination2->translate('fr')->setName('Antigua et Barbuda');
        $destination2->translate('en')->setName('Antigua and Barbuda');
        $destination2->setPublished(true);
        array_push($destinations, $destination2);
        
        $destination3 = new Destination();        
        $destination3->translate('fr')->setName('Aruba');
        $destination3->translate('en')->setName('Aruba');
        $destination3->setPublished(true);
        array_push($destinations, $destination3);
        
        $destination4 = new Destination();        
        $destination4->translate('fr')->setName('Barbade');
        $destination4->translate('en')->setName('Barbados');
        $destination4->setPublished(true);
        array_push($destinations, $destination4);
        
        $destination5 = new Destination();        
        $destination5->translate('fr')->setName('Bonaire');
        $destination5->translate('en')->setName('Bonaire');
        $destination5->setPublished(true);
        array_push($destinations, $destination5);
        
        $destination6 = new Destination();        
        $destination6->translate('fr')->setName('Curacao');
        $destination6->translate('en')->setName('Curacao');
        $destination6->setPublished(true);
        array_push($destinations, $destination6);
        
        $destination7 = new Destination();        
        $destination7->translate('fr')->setName('République Dominicaine');
        $destination7->translate('en')->setName('Dominican Republic');
        $destination7->setPublished(true);
        array_push($destinations, $destination7);
        
        $destination8 = new Destination();        
        $destination8->translate('fr')->setName('Guadeloupe');
        $destination8->translate('en')->setName('Guadeloupe');
        $destination8->setPublished(true);
        array_push($destinations, $destination8);
        
        $destination9 = new Destination();        
        $destination9->translate('fr')->setName('Île de la Tortue (Venezuela)');
        $destination9->translate('en')->setName('Isla La Tortuga');
        $destination9->setPublished(true);
        array_push($destinations, $destination9);
        
        $destination10 = new Destination();        
        $destination10->translate('fr')->setName('Jamaïque');
        $destination10->translate('en')->setName('Jamaica');
        $destination10->setPublished(true);
        array_push($destinations, $destination10);
        
        $destination11 = new Destination();        
        $destination11->translate('fr')->setName('Las Aves');
        $destination11->translate('en')->setName('Las Aves');
        $destination11->setPublished(true);
        array_push($destinations, $destination11);
        
        $destination12 = new Destination();        
        $destination12->translate('fr')->setName('Los Roques');
        $destination12->translate('en')->setName('Los Roques');
        $destination12->setPublished(true);
        array_push($destinations, $destination12);
        
        $destination13 = new Destination();        
        $destination13->translate('fr')->setName('Margarita');
        $destination13->translate('en')->setName('Margarita');
        $destination13->setPublished(true);
        array_push($destinations, $destination13);
        
        $destination14 = new Destination();        
        $destination14->translate('fr')->setName('Martinique');
        $destination14->translate('en')->setName('Martinique');
        $destination14->setPublished(true);
        array_push($destinations, $destination14);
        
        $destination15 = new Destination();        
        $destination15->translate('fr')->setName('Porto Rico');
        $destination15->translate('en')->setName('Puerto Rico');
        $destination15->setPublished(true);
        array_push($destinations, $destination15);
        
        $destination16 = new Destination();        
        $destination16->translate('fr')->setName('San Blas');
        $destination16->translate('en')->setName('San Blas');
        $destination16->setPublished(true);
        array_push($destinations, $destination16);
        
        $destination17 = new Destination();        
        $destination17->translate('fr')->setName('San Blas');
        $destination17->translate('en')->setName('San Blas');
        $destination17->setPublished(true);
        array_push($destinations, $destination17);
        
        $destination18 = new Destination();        
        $destination18->translate('fr')->setName('St Barth');
        $destination18->translate('en')->setName('St Barth');
        $destination18->setPublished(true);
        array_push($destinations, $destination18);
        
        $destination19 = new Destination();        
        $destination19->translate('fr')->setName('St Kitts et Nevis');
        $destination19->translate('en')->setName('St Kitts and Nevis');
        $destination19->setPublished(true);
        array_push($destinations, $destination19);
        
        $destination20 = new Destination();        
        $destination20->translate('fr')->setName('Saint Martin');
        $destination20->translate('en')->setName('St Martin');
        $destination20->setPublished(true);
        array_push($destinations, $destination20);
        
        $destination21 = new Destination();        
        $destination21->translate('fr')->setName('Ste Lucie');
        $destination21->translate('en')->setName('Ste Lucia');
        $destination21->setPublished(true);
        array_push($destinations, $destination21);
        
        $destination22 = new Destination();        
        $destination22->translate('fr')->setName('Les Bahamas');
        $destination22->translate('en')->setName('The Bahamas');
        $destination22->setPublished(true);
        array_push($destinations, $destination22);
        
        $destination23 = new Destination();        
        $destination23->translate('fr')->setName('BVI');
        $destination23->translate('en')->setName('The BVI\'s');
        $destination23->setPublished(true);
        array_push($destinations, $destination23);
        
        $destination24 = new Destination();        
        $destination24->translate('fr')->setName('Les îles Cayman');
        $destination24->translate('en')->setName('The Cayman islands');
        $destination24->setPublished(true);
        array_push($destinations, $destination24);
        
        $destination25 = new Destination();        
        $destination25->translate('fr')->setName('Grenadines');
        $destination25->translate('en')->setName('The Grenadines');
        $destination25->setPublished(true);
        array_push($destinations, $destination25);
        
        $destination26 = new Destination();        
        $destination26->translate('fr')->setName('Trinidad et Tobago');
        $destination26->translate('en')->setName('Trinidad and Tobago');
        $destination26->setPublished(true);
        array_push($destinations, $destination26);
        
        $destination27 = new Destination();        
        $destination27->translate('fr')->setName('Les îles Turks et Caicos');
        $destination27->translate('en')->setName('Turks and Caicos Islands');
        $destination27->setPublished(true);
        array_push($destinations, $destination27);
        
        $destination28 = new Destination();        
        $destination28->translate('fr')->setName('Les îles Vierges Américaines');
        $destination28->translate('en')->setName('US Virgin Islands');
        $destination28->setPublished(true);
        array_push($destinations, $destination28);
        
        foreach($destinations as $key => $destination) {
            $manager->persist($destination);
            $destination->mergeNewTranslations();
        }
        $manager->flush();
    }

}

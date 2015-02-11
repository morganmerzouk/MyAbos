<?php
// src/AppBundle/DataFixtures/EnSavoirPlusFixtures.php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Gedmo\Translatable\TranslatableListener;
use AppBundle\Entity\EnSavoirPlus;

class EnSavoirPlusFixtures implements FixtureInterface {
    public function load(ObjectManager $manager)
    {
        $this->loadMeteo($manager);
        $this->loadReseau($manager);
        $this->loadCroisiere($manager);
    }

    public function loadMeteo(ObjectManager $manager) {
        $meteo = new EnSavoirPlus();
        
        $meteo->translate('fr')->setName("Météo");
        $meteo->translate('en')->setName("Weather forecast");
        
        $meteo->translate('fr')->setDescription("
            Si vous cherchez un paradis du kite, la Caraïbe est probablement ce qui se rapproche le plus du nirvana des sports nautiques!
            Balayée par des alizés constants, entourée d'eaux inconditionnellement turquoises qui ne descendent jamais sous les 25 degrés, bercée par la houle, on peut difficilement demander plus! La saison ventée dans la Caraïbe débute en Décembre et dure jusqu'en Juillet. On peut s'attendre à d'excellentes conditions de surf entre Décembre et Mars, et bien sûr, durant la saison cyclonique.*
            * La saison cyclonique débute le 1er juin et dure jusqu'au 30 novembre. Si le vent devient très imprévisible entre Août et Novembre, ces mois peuvent réserver de magnifiques surprises, avec de la houle cyclonique -qui transforme les rivages de la Caraïbe en des paysages hawaïiens!- et du vent à revendre! Notez qu'aucun d'entre nous ne propose de croisière en septembre et octobre. ");
        $meteo->translate('en')->setDescription("
            If you're looking for a kitesurfing paradise, the Caribbean are as close as it gets from heaven!
            Blessed with steady trade winds, waters unconditionnally turquoise that never drops below 25C° and great surf, one can hardly ask for more! The Caribbean windy season starts in December and last until July; one can expect pumping swell between December and March, and of course, during hurricane season! *
            * Hurricane season starts the 1st of June and ends on the 30th of November. If the weather forecast becomes very unpredictable between August and November, these months can sometimes be full of brilliant surprises, with sick hurricane swell (which turns the Caribbean into Hawaï) and strong winds. Note that we never operate during September and October.");
        
        $meteo->setLien1('http://www.lien1.com');
        $meteo->setLien2('http://www.windfinder.com/weather-maps/report/#4/10.40/289.69');
        $meteo->setLien3('http://magicseaweed.com/Southern-Caribbean-Surf-Chart/53/?chartType=WMAG');
        $meteo->setLien4('http://www.windguru.cz/fr/index.php?sc=3604');
        $meteo->setLien5('http://www.kitesurfarisxm.com/en/kitesurf-links.html');
                
        $meteo->translate('fr')->setLibelleLien2("Windfinder: moyennes de vent dans la Caraibe");
        $meteo->translate('en')->setLibelleLien2("Windfinder Wind reports in the Caribbean");
        
        $meteo->translate('fr')->setLibelleLien3("Magic Seaweed: prévisions houle et vent dans les caraibes");
        $meteo->translate('en')->setLibelleLien3("Magic Seaweed upcoming swell and wind Forecast in the Caribbean");
        
        $meteo->translate('fr')->setLibelleLien4("Windguru prévisions locales");
        $meteo->translate('en')->setLibelleLien4("Windguru Local upcoming Forecast");
        
        $meteo->translate('fr')->setLibelleLien5("Autres liens utiles");
        $meteo->translate('en')->setLibelleLien5("Other useful links");
        
        $meteo->setPublished(true);
        
        $manager->persist($meteo);
        $meteo->mergeNewTranslations();
        $manager->flush();
    }
    
    public function loadReseau(ObjectManager $manager) {
        $reseau = new EnSavoirPlus();
        
        $reseau->translate('fr')->setName("Réseau");
        $reseau->translate('en')->setName("Network");
        
        $reseau->translate('fr')->setDescription("
            Le réseau kitesurfari sxm a été créé en 2008 avec pour objectif de permettre aux petits croisiéristes spécialisés dans le kite d'être facilement référencés et directement contacté par les riders cherchant une croisière proposant des itinéraires adaptés aux kitesurfeurs.
            Le réseau a débuté avec les quelques skippers en place a l'époque et a grandit depuis, accueillant les nouveaux professionnels spécialisés dans les charters de kitesurf.
            Se joindre au réseau est gratuit pour les professionnels, et le consulter est gratuit pour les utilisateurs!");
        $reseau->translate('en')->setDescription("
            Kitesurfari Sxm's network got created in 2008 with the goal to allow all the small kitesurfing charterers to be found and contacted easily and directly by any rider looking for a kiteboarding specialised cruise.
            The network started with the few skippers in place at the time, and has been growing since, welcoming any new professional specialised in kiting cruises ever since.
            Joining the network is free for the professionals and so is the data access for all its users!");
        
                
        $reseau->translate('fr')->setLibelleLien2("L'histoire de Kitesurfari Sxm");
        $reseau->translate('en')->setLibelleLien2("Kitesurfari Sxm's story");
        
        $reseau->translate('fr')->setLibelleLien3("Le concept du réseau");
        $reseau->translate('en')->setLibelleLien3("Kitesurfari Sxm's concept");
        
        $reseau->translate('fr')->setLibelleLien4("Les partenaires de Kitesurfari Sxm");
        $reseau->translate('en')->setLibelleLien4("Kitesurfari Sxm's partners");
        
        
        $reseau->setPublished(true);
        
        $manager->persist($reseau);
        $reseau->mergeNewTranslations();
        $manager->flush();
    }
    
    public function loadCroisiere(ObjectManager $manager) {
        $croisiere = new EnSavoirPlus();
        
        $croisiere->translate('fr')->setName("Croisière");
        $croisiere->translate('en')->setName("Cruise");
        
        $croisiere->translate('fr')->setDescription("Vous trouverez ici des informations complémentaire sur les croisières kitesurf: la foire aux questions et davantages de détails sur le déroulement des croisières, la vie à bord et les itinéraires.");
        $croisiere->translate('en')->setDescription("Find here some information about kitesurfing cruises: the answers to the most frequently asked questions about kite cruises and some additional details about what a kitesurfing cruise is like, life on board, itineraries.");
        
        $croisiere->setPublished(true);
        
        $manager->persist($croisiere);
        $croisiere->mergeNewTranslations();
        $manager->flush();
    }
    
}

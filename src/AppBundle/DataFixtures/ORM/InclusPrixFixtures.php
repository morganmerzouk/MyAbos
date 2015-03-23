<?php
// src/AppBundle/DataFixtures/ORM/DestinationFixtures.php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\InclusPrix;
use Symfony\Component\Yaml\Yaml;

class InclusPrixFixtures extends AbstractFixture implements FixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $yml = Yaml::parse(file_get_contents(__DIR__ . "/../inclusprix.yml"));
        foreach ($yml as $key => $item) {
            $inclusPrix = new InclusPrix();
            $inclusPrix->translate('fr')->setName($item['name_fr']);
            $inclusPrix->translate('en')->setName($item['name_en']);
            $inclusPrix->setCategorie($item['categorie']);
            if (isset($item['icone'])) {
                $inclusPrix->setIcone($item['icone']);
            }
            
            $manager->persist($inclusPrix);
            $inclusPrix->mergeNewTranslations();
            $manager->flush();
        }
    }
}

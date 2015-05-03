<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;

class SearchHeaderType extends AbstractType
{

    private $em;

    private $locale;

    public function __construct(EntityManager $em, $locale)
    {
        $this->em = $em;
        $this->locale = $locale;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($this->locale == "en") {
            $format = 'MM/dd/yyyy';
        } else {
            $format = 'dd/MM/yyyy';
        }
        $builder->add('destination', 'choice', array(
            'label' => "",
            "choices" => $this->fillDestination(),
            'required' => false,
            'attr' => array(
                'class' => 'select-destination'
            ),
            'empty_value' => "Where?"
        ))
            ->add('date', 'date', array(
            'label' => "",
            'required' => false,
            'widget' => 'single_text',
            'attr' => array(
                'class' => 'input-date-depart',
                'placeholder' => 'When?'
            ),
            'format' => $format
        ))
            ->add('nbPassager', 'choice', array(
            'label' => '',
            "choices" => $this->fillPassager(),
            'required' => false,
            'attr' => array(
                'class' => 'input-nb-passager'
            ),
            'empty_value' => "Who?"
        ))
            ->setMethod("POST");
    }

    private function fillDestination()
    {
        $results = $this->em->getRepository("AppBundle\Entity\DestinationTranslation")
            ->createQueryBuilder('d')
            ->select('d.translatable_id as id, d.name')
            ->where("d.locale = :locale")
            ->setParameter(":locale", $this->locale)
            ->orderBy('d.name', 'ASC')
            ->getQuery()
            ->getResult();
        $destination = array();
        foreach ($results as $dest) {
            $destination[$dest['id']] = $dest['name'];
        }
        return $destination;
    }

    private function fillPrestation()
    {
        $results = $this->em->getRepository("AppBundle\Entity\PrestationTranslation")
            ->createQueryBuilder('d')
            ->select('d.translatable_id as id, d.name')
            ->where("d.locale = :locale")
            ->setParameter(":locale", $this->locale)
            ->orderBy('d.name', 'ASC')
            ->getQuery()
            ->getResult();
        
        $prestation = array();
        foreach ($results as $prest) {
            $prestation[$prest['id']] = $prest['name'];
        }
        
        return $prestation;
    }

    private function fillPassager()
    {
        if ($this->locale == "en") {
            $passenger = array(
                "1" => "1 passenger",
                "2" => "2 passengers",
                "3" => "3 passengers",
                "4" => "4 passengers",
                "5" => "5 passengers",
                "6" => "6 passengers",
                "7" => "7 passengers",
                "8" => "8 passengers"
            );
        } else {
            $passenger = array(
                "1" => "1 passager",
                "2" => "2 passagers",
                "3" => "3 passagers",
                "4" => "4 passagers",
                "5" => "5 passagers",
                "6" => "6 passagers",
                "7" => "7 passagers",
                "8" => "8 passagers"
            );
        }
        return $passenger;
    }

    public function getName()
    {
        return "search";
    }
}
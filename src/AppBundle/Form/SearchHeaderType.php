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
        $builder->add('dateDepart', 'date', array(
            'label' => "form_depart",
            'required' => false,
            'widget' => 'single_text',
            'attr' => array(
                'class' => 'input-date-depart'
            ),
            'format' => 'dd/MM/yyyy'
        ))
            ->add('dateRetour', 'date', array(
            'label' => "form_retour",
            'required' => false,
            'widget' => 'single_text',
            'attr' => array(
                'class' => 'input-date-retour'
            ),
            'format' => 'dd/MM/yyyy'
        ))
            ->add('destination', 'choice', array(
            "choices" => $this->fillDestination(),
            'attr' => array(
                'class' => 'select-destination'
            ),
            'empty_value' => "toutes"
        ))
            ->add('prestation', 'choice', array(
            "choices" => $this->fillPrestation(),
            'attr' => array(
                'class' => 'select-prestation'
            ),
            'empty_value' => "toutes"
        ))
            ->add('nbPassager', 'text', array(
            'label' => 'form_passenger',
            'required' => false,
            'attr' => array(
                'class' => 'input-nb-passager'
            )
        ));
    }

    private function fillDestination()
    {
        $results = $this->em->getRepository("AppBundle\Entity\DestinationTranslation")
            ->createQueryBuilder('d')
            ->select('d.translatable_id as id, d.name')
            ->where("d.locale = :locale")
            ->setParameter(":locale", $this->locale)
            ->orderBy('d.name', 'ASC');
        
        $destination = array();
        foreach ($results as $dest) {
            $destination[] = array(
                "id" => $dest->getId(),
                "name" => $dest->getName()
            );
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
            ->orderBy('d.name', 'ASC');
        
        $prestation = array();
        foreach ($results as $prest) {
            $prestation[] = array(
                "id" => $prest->getId(),
                "name" => $prest->getName()
            );
        }
        
        return $prestation;
    }

    public function getName()
    {
        return "search";
    }
}
<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;

class BateauDevisType extends AbstractType
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
            'label' => "form_sejour_possible_debut",
            'required' => false,
            'widget' => 'single_text',
            'attr' => array(
                'class' => 'input-date-depart'
            ),
            'format' => 'dd/MM/yyyy'
        ))
            ->add('dateRetour', 'date', array(
            'label' => "form_sejour_possible_fin",
            'label_attr' => array(
                'class' => 'label-date-retour'
            ),
            'required' => false,
            'widget' => 'single_text',
            'attr' => array(
                'class' => 'input-date-retour'
            ),
            'format' => 'dd/MM/yyyy'
        ))
            ->add('dureeCroisiere', 'choice', array(
            'label' => 'form_sejour_duree',
            'label_attr' => array(
                'class' => 'label-duree-croisiere'
            ),
            'choice_list' => $this->loadChoiceList("dureeCroisiere"),
            'attr' => array(
                "class" => "select-duree-croisiere"
            )
        ))
            ->add('nbPassager', 'choice', array(
            'label' => 'form_sejour_nb_passager',
            'label_attr' => array(
                'class' => 'label-nb-passager'
            ),
            'choice_list' => $this->loadChoiceList("nbPassager"),
            'attr' => array(
                "class" => "select-nb-passager"
            )
        ))
            ->add('portDepart', 'choice', array(
            "choices" => $this->fillPortDepart(),
            'attr' => array(
                'class' => 'select-portdepart'
            ),
            'empty_value' => "toutes"
        ))
            ->add('destination', 'choice', array(
            "choices" => $this->fillDestination(),
            'label' => 'form_sejour_destination',
            'attr' => array(
                'class' => 'select-destination'
            ),
            'empty_value' => "toutes"
        ));
    }

    protected function loadChoiceList($type)
    {
        if ($type == "nbPassager") {
            $item = array(
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6',
                '7' => '7',
                '8' => '8'
            );
        } elseif ($type == "dureeCroisiere") {
            $item = array(
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6',
                '7' => '7',
                '8' => '8',
                '9' => '9',
                '10' => '10',
                '11' => '11',
                '12' => '12',
                '13' => '13',
                '14' => '14',
                '15' => '15',
                '16' => '16',
                '17' => '17',
                '18' => '17',
                '19' => '19',
                '20' => '20'
            );
        }
        
        $choices = new SimpleChoiceList($item);
        
        return $choices;
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

    private function fillPortDepart()
    {
        $results = $this->em->getRepository("AppBundle\Entity\PortDepartTranslation")
            ->createQueryBuilder('d')
            ->select('d.translatable_id as id, d.name')
            ->where("d.locale = :locale")
            ->setParameter(":locale", $this->locale)
            ->orderBy('d.name', 'ASC')
            ->getQuery()
            ->getResult();
        
        $portDepart = array();
        foreach ($results as $port) {
            $portDepart[$port['id']] = $port['name'];
        }
        
        return $portDepart;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'intention' => 'bateaudevis_item'
        ));
    }

    public function getName()
    {
        return "bateaudevis";
    }
}
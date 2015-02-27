<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SearchHomeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('dateDepart', 'date',array(   'label' => "Départ",
                                                    'required' => false,
                                                    'widget' =>'single_text',
                                                    'attr' =>array('class' => 'input-date-depart'),
                                                    'format' =>'dd/MM/yyyy'))
                    ->add('dateRetour', 'date',array('label' => "Retour",
                                                    'required' => false,
                                                    'widget' =>'single_text',
                                                    'attr'=> array('class' => 'input-date-retour'),
                                                    'format' =>'dd/MM/yyyy'))
                    ->add('destination', 'entity', array(
                                'class' => 'AppBundle:DestinationTranslation',
                                'property' => 'name',
                                'attr' => array('class' =>'select-destination'),
                                'empty_value' => "Toutes"
                            ))
                    ->add('prestation', 'entity', array(
                                'class' => 'AppBundle:PrestationTranslation',
                                'property' => 'name',
                                'attr' => array('class' =>'select-prestation'),
                                'empty_value' => "Toutes"
                            ))
                    ->add('nbPassager', 'text', array('label' => 'Passagers', 'required'=>false, 
                                'attr' => array('class' =>'input-nb-passager')))
                ;
    }

    public function getName() {
        return "search";
    }

}
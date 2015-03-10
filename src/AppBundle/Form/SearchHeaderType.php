<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SearchHeaderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('dateDepart', 'date',array(   'label' => "form_depart",
                                                    'required' => false,
                                                    'widget' =>'single_text',
                                                    'attr' =>array('class' => 'input-date-depart'),
                                                    'format' =>'dd/MM/yyyy'))
                    ->add('dateRetour', 'date',array('label' => "form_retour",
                                                    'required' => false,
                                                    'widget' =>'single_text',
                                                    'attr'=> array('class' => 'input-date-retour'),
                                                    'format' =>'dd/MM/yyyy'))
                    ->add('destination', 'entity', array(
                                'class' => 'AppBundle:Destination',
                                'property' => 'name',
                                'attr' => array('class' =>'select-destination'),
                                'empty_value' => "toutes"
                            ))
                    ->add('prestation', 'entity', array(
                                'class' => 'AppBundle:Prestation',
                                'property' => 'name',
                                'attr' => array('class' =>'select-prestation'),
                                'empty_value' => "toutes"
                            ))
                    ->add('nbPassager', 'text', array('label' => 'form_passenger', 'required'=>false, 
                                'attr' => array('class' =>'input-nb-passager')))
                ;
    }

    public function getName() {
        return "search";
    }

}
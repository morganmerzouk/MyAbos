<?php
namespace App\BackOfficeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProviderType extends AbstractType
{

    /**
     *
     * @param FormBuilderInterface $builder            
     * @param array $options            
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('category', 'entity', array(
            'label' => "Catégorie:",
            'class' => 'AppMainBundle:Category',
            'choice_label' => 'name'
        ))
            ->add('name', 'text', array(
            'label' => "Libellé:"
        ))
            ->add('address', 'textarea', array(
            'label' => "Adresse:"
        ))
            ->add('miniatureFile', 'file', array(
            'label' => "Logo:",
            'required' => false
        ))
            ->add('actif', 'checkbox', array(
            'label' => 'Public:',
            'required' => false
        ));
    }

    /**
     *
     * @param OptionsResolverInterface $resolver            
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\MainBundle\Entity\Provider'
        ));
    }

    /**
     *
     * @return string
     */
    public function getName()
    {
        return 'app_mainbundle_provider';
    }
}

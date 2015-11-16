<?php
namespace App\FrontOfficeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContractType extends AbstractType
{

    /**
     *
     * @param FormBuilderInterface $builder            
     * @param array $options            
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('provider')
            ->add('number')
            ->add('startingDate', 'date')
            ->add('endingDate', 'date')
            ->add('amount')
            ->add('amountFrequency')
            ->add('withEngagement', 'choice', array(
            'choices' => array(
                '1' => 'Oui',
                '0' => 'Non'
            ),
            'expanded' => true,
            'multiple' => false
        ))
            ->add('autoRenewal', 'choice', array(
            'choices' => array(
                '1' => 'Oui',
                '0' => 'Non'
            ),
            'expanded' => true,
            'multiple' => false
        ))
            ->add('engagementLength')
            ->add('alertFrequency')
            ->add('contractFile', 'file');
    }

    /**
     *
     * @param OptionsResolverInterface $resolver            
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\MainBundle\Entity\Contract'
        ));
    }

    /**
     *
     * @return string
     */
    public function getName()
    {
        return 'app_mainbundle_contract';
    }
}

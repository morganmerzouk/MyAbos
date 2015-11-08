<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserRegistrationStep1Type extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstname', 'text', array(
            'attr' => array(
                'placeholder' => 'Prénom'
            ),
            'label' => 'Prénom'
        ))
            ->add('lastname', 'text', array(
            'attr' => array(
                'placeholder' => 'Nom'
            ),
            'label' => 'Nom'
        ))
            ->add('email', 'email', array(
            'attr' => array(
                'placeholder' => 'Email'
            ),
            'label' => 'Email'
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Application\Sonata\UserBundle\Entity\User'
        ));
    }

    public function getName()
    {
        return 'user';
    }
}
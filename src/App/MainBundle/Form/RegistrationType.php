<?php
namespace App\MainBundle\Form;

use FOS\UserBundle\Form\Type\RegistrationFormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegistrationType extends RegistrationFormType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->remove('username')
            ->add('firstname', 'text', array(
            'attr' => array(
                'placeholder' => "Prénom *"
            ),
            'label' => 'Prénom *'
        ))
            ->add('lastname', 'text', array(
            'attr' => array(
                'placeholder' => "Nom *"
            ),
            'label' => 'Nom *'
        ))
            ->add('email', 'email', array(
            'attr' => array(
                'placeholder' => "Email *"
            ),
            'label' => 'Email *'
        ))
            ->add('gender', 'choice', array(
            'choices' => array(
                'u' => 'Sexe',
                'm' => 'Masculin',
                'f' => 'Féminin'
            ),
            'label' => 'Sexe'
        ))
            ->add('phone', 'text', array(
            'attr' => array(
                'placeholder' => "Téléphone"
            ),
            'label' => 'Téléphone'
        ))
            ->add('plainPassword', 'repeated', array(
            'type' => 'password',
            'first_options' => array(
                'attr' => array(
                    "placeholder" => "Créer un mot de passe *"
                ),
                'label' => 'Créer un mot de passe *'
            ),
            'second_options' => array(
                'attr' => array(
                    "placeholder" => "Confirmer le mot de passe *"
                ),
                'label' => 'Confirmer le mot de passe *'
            )
        ));
    }

    public function setDefaultOption(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'validation_groups' => array(
                'Default',
                'Register'
            )
        ));
    }

    public function getName()
    {
        return 'app_fos_user_register';
    }
}
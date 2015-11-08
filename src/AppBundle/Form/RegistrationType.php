<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstname', 'text', array(
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
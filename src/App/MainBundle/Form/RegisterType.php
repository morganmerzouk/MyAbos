<?php
namespace App\MainBundle\Form;

use FOS\UserBundle\Form\Type\RegistrationFormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegisterType extends RegistrationFormType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->remove('username')
            ->add('gender', 'choice', array(
            'choices' => array(
                'u' => 'profile.fields.gender.none',
                'm' => 'profile.fields.gender.masculin',
                'f' => 'profile.fields.gender.feminin'
            ),
            'required' => 'true',
            'attr' => array(
                'class' => 'form-control input-lg',
                "placeholder" => "profile.fields.gender.none"
            )
        ))
            ->add('firstname', 'text', array(
            'label' => 'profile.fields.firstname',
            'required' => 'true',
            'attr' => array(
                'class' => 'form-control input-lg',
                "placeholder" => "profile.fields.firstname"
            )
        ))
            ->add('lastname', 'text', array(
            'label' => 'profile.fields.lastname',
            'required' => 'true',
            'attr' => array(
                'class' => 'form-control input-lg',
                "placeholder" => "profile.fields.lastname"
            )
        ))
            ->add('email', 'email', array(
            'label' => 'profile.fields.email',
            'required' => 'true',
            'attr' => array(
                'class' => 'form-control input-lg',
                "placeholder" => "profile.fields.email"
            )
        ))
            ->add('phone', 'text', array(
            'label' => 'profile.fields.phone',
            'attr' => array(
                'class' => 'form-control input-lg',
                "placeholder" => "profile.fields.phone"
            )
        ))
            ->add('plainPassword', 'repeated', array(
            'type' => 'password',
            'invalid_message' => 'The password fields must match.',
            'first_options' => array(
                'label' => 'profile.fields.password',
                'attr' => array(
                    'class' => 'form-control input-lg',
                    "placeholder" => "profile.fields.password"
                )
            ),
            'second_options' => array(
                'label' => 'profile.fields.password_repeat',
                'attr' => array(
                    'class' => 'form-control input-lg',
                    "placeholder" => "profile.fields.password_repeat"
                )
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
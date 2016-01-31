<?php
namespace App\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;

class ContactType extends AbstractType
{

    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('message', 'textarea', array(
            'label' => 'Message',
            'label_attr' => array(
                'class' => 'label-textarea-message'
            ),
            'attr' => array(
                'placeholder' => 'Message',
                'class' => 'textarea-message col-md-12'
            )
        ))
            ->add('nom', 'text', array(
            'label' => 'Nom:',
            'required' => false,
            'label_attr' => array(
                'class' => 'label-nom'
            ),
            'attr' => array(
                'placeholder' => 'Nom',
                'class' => 'input-nom col-md-6'
            )
        ))
            ->add('email', 'email', array(
            'label' => 'Email',
            'required' => false,
            'label_attr' => array(
                'class' => 'label-email'
            ),
            'attr' => array(
                'placeholder' => 'Email',
                'class' => 'input-email col-md-6'
            )
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'intention' => 'contact_item'
        ));
    }

    public function getName()
    {
        return "contact";
    }
}
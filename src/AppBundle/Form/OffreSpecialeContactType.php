<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;

class OffreSpecialeContactType extends AbstractType
{

    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('message', 'textarea', array(
            'label' => 'form_sejour_message',
            'label_attr' => array(
                'class' => 'label-textarea-message'
            ),
            'attr' => array(
                'class' => 'textarea-message'
            )
        ))
            ->add('nom', 'text', array(
            'label' => 'form_sejour_nom',
            'label_attr' => array(
                'class' => 'label-nom'
            ),
            'attr' => array(
                'class' => 'input-nom'
            )
        ))
            ->add('email', 'email', array(
            'label' => 'form_sejour_email',
            'label_attr' => array(
                'class' => 'label-email'
            ),
            'attr' => array(
                'class' => 'input-email'
            )
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'intention' => 'offrespecialecontact_item'
        ));
    }

    public function getName()
    {
        return "offrespecialecontact";
    }
}
<?php
namespace App\FrontOfficeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class ContractType extends AbstractType
{

    /**
     *
     * @param FormBuilderInterface $builder            
     * @param array $options            
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('category', 'entity', array(
            'label' => false,
            'class' => 'AppMainBundle:Category',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('c')
                    ->andWhere("c.actif = 1")
                    ->orderBy('c.name', 'ASC');
            },
            'attr' => array(
                'class' => 'hidden form-category'
            )
        ))
            ->add('name', 'text', array(
            'attr' => array(
                'placeholder' => 'Nom du contrat',
                'class' => "form-control"
            )
        ))
            ->add('provider', 'choice', array(
            'attr' => array(
                'class' => "form-control"
            ),
            'choices' => array(
                'Fournisseur' => 'Fournisseur',
                'Bouygues Telecom' => 'Bouygues Telecom',
                'Free' => 'Free',
                'Orange' => 'Orange',
                'Sfr' => 'SFR'
            ),
            'expanded' => false,
            'multiple' => false
        ))
            ->add('number', 'text', array(
            'attr' => array(
                'class' => "form-control",
                'placeholder' => 'Numéro de contrat'
            )
        ))
            ->add('startingDate', 'date', array(
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy',
            'label_attr' => array(
                'class' => 'col-md-6'
            ),
            'attr' => array(
                'class' => "form-control date"
            ),
            'label' => "Date d'engagement"
        ))
            ->add('endingDate', 'date', array(
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy',
            'label_attr' => array(
                'class' => 'col-md-6'
            ),
            'attr' => array(
                'class' => "form-control date"
            ),
            'label' => "Date de fin d'engagement"
        ))
            ->add('amount', 'text', array(
            'attr' => array(
                'class' => "form-control col-md-6",
                'placeholder' => "Montant de l'abonnement"
            )
        ))
            ->add('amountFrequency', 'choice', array(
            'attr' => array(
                'class' => "form-control col-md-6"
            ),
            'choices' => array(
                'jour' => 'par jour',
                'semaine' => 'par semaine',
                'an' => 'par an'
            ),
            'expanded' => false,
            'multiple' => false
        ))
            ->add('withEngagement', 'choice', array(
            'label_attr' => array(
                'class' => 'col-md-6'
            ),
            'attr' => array(
                'class' => "col-md-6"
            ),
            'choices' => array(
                '1' => 'Oui',
                '0' => 'Non'
            ),
            'expanded' => true,
            'multiple' => false,
            "label" => "Contrat avec engagement",
            'data' => 1
        ))
            ->add('autoRenewal', 'choice', array(
            'label_attr' => array(
                'class' => 'col-md-6'
            ),
            'attr' => array(
                'class' => "col-md-6"
            ),
            'choices' => array(
                '1' => 'Oui',
                '0' => 'Non'
            ),
            'expanded' => true,
            'multiple' => false,
            "label" => "Reconduction tacite",
            'data' => 1
        ))
            ->add('engagementLength', 'choice', array(
            'attr' => array(
                'class' => "form-control"
            ),
            'choices' => array(
                '' => "Durée d'engagement",
                '0' => 'Sans engagement',
                '1' => '1 mois',
                '6' => '6 mois',
                '12' => '12 mois',
                '18' => '18 mois',
                '24' => '24 mois'
            )
        ))
            ->add('alertFrequency', 'choice', array(
            'attr' => array(
                'class' => "form-control"
            ),
            'choices' => array(
                '' => "Fréquence d'alerte",
                'semaine' => 'Une fois par semaine',
                'mois' => 'Une fois par mois',
                'an' => 'Une fois par an'
            )
        ))
            ->add('contractFile', 'file', array(
            'required' => false,
            'label' => "Téléchargement contrat + factures"
        ));
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

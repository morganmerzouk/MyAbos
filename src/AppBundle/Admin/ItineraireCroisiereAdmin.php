<?php
// src/AppBundle/Admin/TarifCroisiereAdmin.php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;

class ItineraireCroisiereAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('dateDebut', 'sonata_type_date_picker', array(
            'label' => 'Date début: ',
            'required' => true,
            'format' => 'dd/MM/yyyy'
        ))
            ->add('dateFin', 'sonata_type_date_picker', array(
            'label' => 'Date fin: ',
            'required' => true,
            'format' => 'dd/MM/yyyy'
        ))
            ->add('itineraire', 'entity', array(
            'class' => 'AppBundle\Entity\Itineraire',
            'label' => "Itineraire: ",
            'attr' => array(
                'class' => 'itinerairecroisiere-itineraire'
            )
        ))
            ->add('variationPrix', 'text', array(
            'label' => 'Variation prix: ',
            'attr' => array(
                'class' => 'itinerairecroisiere-variation-prix'
            ),
            'required' => false
        ))
            ->add('tarifAppliqueSur', 'choice', array(
            'label' => 'Tarif à appliquer sur: ',
            'required' => false,
            'choice_list' => $this->loadChoiceList("tarifAppliqueSur"),
            'attr' => array(
                'class' => 'itinerairecroisiere-tarifappliquesur'
            )
        ))
            ->add('parDefaut', 'checkbox', array(
            'label' => 'Par défaut?: ',
            'required' => false
        ));
    }
    
    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('dateDebut', 'date', array(
            'label' => 'Date début: '
        ))
            ->add('dateFin', 'date', array(
            'label' => 'Date fin: '
        ))
            ->add('_action', 'actions', array(
            'actions' => array(
                'edit' => array(),
                'delete' => array()
            )
        ));
    }

    protected function loadChoiceList($type)
    {
        if ($type == "tarifAppliqueSur") {
            $item = array(
                'Par personne par jour' => 'Par personne par jour',
                'Pour le bateau par jour' => 'Pour le bateau par jour',
                'Par personne pour le séjour' => 'Par personne pour le séjour',
                'Pour le bateau pour le séjour' => 'Pour le bateau pour le séjour'
            );
        }
        
        $choices = new SimpleChoiceList($item);
        
        return $choices;
    }

    public function setBaseRouteName($baseRouteName)
    {
        $this->baseRouteName = $baseRouteName;
    }

    public function setBaseRoutePattern($baseRoutePattern)
    {
        $this->baseRoutePattern = $baseRoutePattern;
    }
}
<?php
// src/AppBundle/Admin/DateNonDisponibiliteAdmin.php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;

class DateNonDisponibiliteAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('dateDebut', 'sonata_type_date_picker', array(
            'label' => 'Date début: ',
            'required' => true,
            'format' => 'dd/MM/yyyy'
        ))->add('dateFin', 'sonata_type_date_picker', array(
            'label' => 'Date fin: ',
            'required' => true,
            'format' => 'dd/MM/yyyy'
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

    public function setBaseRouteName($baseRouteName)
    {
        $this->baseRouteName = $baseRouteName;
    }

    public function setBaseRoutePattern($baseRoutePattern)
    {
        $this->baseRoutePattern = $baseRoutePattern;
    }
}
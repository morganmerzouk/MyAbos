<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;

class DevisAdmin extends Admin
{
    
    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('nom', 'null', array(
            'label' => 'Nom: '
        ))
            ->add('skipper', 'null', array(
            'label' => 'Skipper: '
        ))
            ->add('message', 'null', array(
            'label' => 'Message: '
        ))
            ->add('createdAt', 'date', array(
            'label' => 'Envoyé le: '
        ))
            ->add('_action', 'actions', array(
            'actions' => array(
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
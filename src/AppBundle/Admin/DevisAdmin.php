<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;

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
            ->add('createdAt', 'datetime', array(
            'label' => 'Créé le: '
        ))
            ->add('sendAt', 'datetime', array(
            'label' => 'Envoyé le: '
        ))
            ->add('readAt', 'datetime', array(
            'label' => 'Lu le: '
        ))
            ->add('_action', 'actions', array(
            'actions' => array(
                'delete' => array(),
                'Email' => array(
                    'template' => 'AppBundle:Admin/CRUD:list__action_email.html.twig'
                )
            )
        ));
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('email', $this->getRouterIdParameter() . '/email');
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
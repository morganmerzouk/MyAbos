<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;

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
            ->add('offrespecialeId', 'null', array(
            'label' => 'Offre spéciale: '
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

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        
        return new ProxyQuery($query->andWhere("o.actif=1"));
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
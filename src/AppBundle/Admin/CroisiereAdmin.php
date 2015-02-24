<?php
// src/AppBundle/Admin/CroisiereAdmin.php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Sonata\AdminBundle\Route\RouteCollection;

class CroisiereAdmin extends Admin
{    
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $optionsMiniature = array('label' => 'Miniature: ', 'required' => false, 'label_attr' => array('class' => 'control-miniature'), 'attr' => array('class' => 'croisiere-miniature'));
        
        $croisiere = $this->getSubject();
        
        if ($croisiere->getMiniatureWebPath()) {$optionsMiniature['help'] = '<img src="' . $croisiere->getMiniatureWebPath(). '" class="preview-img" />';}
        $em = $this->modelManager->getEntityManager('AppBundle\Entity\InclusPrix');
        
        $queryServicePayant = $em->createQueryBuilder('sp')
        ->select('sp')
        ->from('AppBundle:ServicePayant', 'sp')
        ->leftJoin('AppBundle:ServicePayantTranslation', 'spt', 'WITH', 'sp.id=spt.translatable_id')
        ->orderBy('spt.name', 'ASC');
        
        $formMapper
            ->add('miniatureFile', 'file', $optionsMiniature)
            ->add('translations', 'a2lix_translations', array(
                    'fields' => array(                      
                        'name' => array(         
                            'label' => 'Nom: ',
                            'locale_options' => array(
                                'en' => array(
                                    'label' => 'Name: '
                                ),
                            'required' => false
                            )
                        ), 
                        'description' => array(         
                            'label' => 'Description: ',             
                            'label_attr' => array('class' => 'control-description'),               
                            'attr' => array('class' => 'tinymce', 'data-theme' => 'advanced'),
                            'locale_options' => array(
                                'en' => array(
                                    'label' => 'Description: '
                                ),
                            'required' => false,
                            'class' => 'tinymce'
                            )
                        ),     
                        'translatable_id' => array(   
                            'field_type' => 'hidden'
                        )
                    ),       
                ))
            ->add('bateau', 'entity', array(
                    'class'    => 'AppBundle\Entity\Bateau',
                    'label'    => "Bateau: "
                ))
            ->add('skipper', 'entity', array(
                    'class'    => 'AppBundle\Entity\Skipper',
                    'label'    => "Skipper: "
                ))
            ->add('dateNonDisponibilite', 'sonata_type_model',array('label'=>'Date de non disponibilité: ','multiple'=>true,'required'=>false))   
            ->add('tarifCroisiere', 'sonata_type_model',array('label'=>'Grille de tarif: ','multiple'=>true,'required'=>false))   
            ->add('servicePayant', 'sonata_type_model', array('query' => $queryServicePayant,
                'label_attr'=>array('class'=>'control-croisiere-servicepayant'),
                'attr'=>array("class"=>"croisiere-servicepayant"),
                'required'=>false,
                'multiple'=>true,
                'empty_value'=>'Service',
                'label' => 'Services Payants: ',
                'btn_add'=>false))
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name', 'translatable_field', array(
                'field'                => 'name',
                'personal_translation' => 'AppBundle\Entity\CroisiereTranslation',
                'property_path'        => 'translations',
                'label'                => 'Nom: '
            ))
            ->add('published', null, array('label' => 'Publié: '))
            ->add('_action', 'actions',
                array(
                    'actions' => array(
                        'edit' => array(),
                        'delete' => array(),
                     //   'Clone' => array(
                     //       'template' => 'AppBundle:Admin/CRUD:list__action_clone.html.twig'
                     //   )
                    )
                ))
        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        //$collection->add('clone', $this->getRouterIdParameter().'/clone');
        $collection->add('getServicePayant', 'getServicePayant/{id}', array('id'=>null));
    }
    
    public function setBaseRouteName($baseRouteName)
    {
        $this->baseRouteName = $baseRouteName;
    }
    
    public function setBaseRoutePattern($baseRoutePattern)
    {
        $this->baseRoutePattern = $baseRoutePattern;
    }
    
    
    public function prePersist($destination) {
        $this->saveFile($destination);
    }
    
    public function preUpdate($destination) {
        $this->saveFile($destination);
    }
    
    public function saveFile($destination) {
        $basepath = $this->getRequest()->getBasePath();
        $destination->upload($basepath);
    }
}
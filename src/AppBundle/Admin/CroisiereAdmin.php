<?php
// src/AppBundle/Admin/CroisiereAdmin.php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;


class CroisiereAdmin extends Admin
{    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $optionsMiniature = array('label' => 'Miniature: ', 'required' => false, 'label_attr' => array('class' => 'control-miniature'), 'attr' => array('class' => 'croisiere-miniature'));
        
        $croisiere = $this->getSubject();
        
        if ($croisiere->getMiniatureWebPath()) {$optionsMiniature['help'] = '<img src="' . $croisiere->getMiniatureWebPath(). '" class="preview-img" />';}
        
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
            ->add('dateNonDisponibilite', 'sonata_type_model',array('label'=>'Date de non disponibilité: ','multiple'=>true))   
            ->add('tarifCroisiere', 'sonata_type_model',array('label'=>'Grille de tarif: ','multiple'=>true))   
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
                        'delete' => array()
                    )
                ))
        ;
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
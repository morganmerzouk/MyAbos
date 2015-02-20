<?php
// src/AppBundle/Admin/InclusPrixAdmin.php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

class InclusPrixAdmin extends Admin
{    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $optionsMiniature = array('label' => 'Miniature: ', 'required' => false, 'label_attr' => array('class' => 'control-miniature'), 'attr' => array('class' => 'inclusprix-miniature'));
        
        $inclusPrix = $this->getSubject();
        
        if ($inclusPrix->getMiniatureWebPath()) {$optionsMiniature['help'] = '<img src="' . $inclusPrix->getMiniatureWebPath(). '" class="preview-img" />';}
        
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
                            'required' => false,
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
                        ),
                    )))
                ->add('prestation', 'entity', array(
                    'class'    => 'AppBundle\Entity\Prestation',
                    'label'  => 'Rattachement à une prestation: ',
                    'required' => false,
                    "empty_value" => "Aucune",
                    'label_attr' => array('class' => 'control-inclusprix-prestation'),
                    'attr' => array("class"=>"inclusprix-list-radio"),
                ))
                ->add('categorie', 'choice', array('label' => 'Catégorie: ',
                    'label_attr' => array('class' => 'control-inclusprix-categorie'),    
                    'choice_list' => $this->loadChoiceList("categorie")
                ))
                ->add('published', 'checkbox', array('label' => 'Publié: ', 'required'=> false, 'attr'=>array('class'=>'inclusprix-publie')))
        ;
    }
    
        protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
        ->add('prestation', null, array('label' => 'Prestation: '))
        ->add('categorie', "doctrine_orm_choice", array('label' => 'Catégorie: ', 'class' => 'optionpayante-filter-categorie', 
            'field_options' =>
                array('choices'=> array(
                    'Equipage' => 'Equipage',
                    'Frais de voyage' => 'Frais de voyage',
                    'Avitaillement' => 'Avitaillement',
                    'Autres services' => 'Autres services',
                    'Equipements à bord' => 'Equipements à bord',
                    'Activités à bord' => 'Activités à bord',
                    'Cours de kitesurf' => 'Cours de kitesurf'
                )), 'field_type' => 'choice'));
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name', 'translatable_field', array(
                'field'                => 'name',
                'personal_translation' => 'AppBundle\Entity\InclusPrixTranslation',
                'property_path'        => 'translations',
                'label'                => 'Nom: ',
                'editable'             => true
            ))
            ->add('categorie', 'translatable_field', array(
                'label'                => 'Catégorie: '
            ))
            ->add('prestation.name', 'translatable_field', array(
                'field'                => 'name',
                'personal_translation' => 'AppBundle\Entity\InclusPrixTranslation',
                'property_path'        => 'translations',
                'label'                => 'Prestation: '
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
    
    
    public function prePersist($inclusPrix) {
        $this->saveFile($inclusPrix);
    }
    
    public function preUpdate($inclusPrix) {
        $this->saveFile($inclusPrix);
    }
    
    public function saveFile($inclusPrix) {
        $basepath = $this->getRequest()->getBasePath();
        $inclusPrix->upload($basepath);
    }
    
    protected function loadChoiceList($type) {
        if($type=="categorie"){
            $item = array(
                    'Equipage' => 'Equipage',
                    'Frais de voyage' => 'Frais de voyage',
                    'Avitaillement' => 'Avitaillement',
                    'Autres services' => 'Autres services',
                    'Equipements à bord' => 'Equipements à bord',
                    'Activités à bord' => 'Activités à bord',
                    'Cours de kitesurf' => 'Cours de kitesurf'
                );
        }
        
        $choices = new SimpleChoiceList($item);
    
        return $choices;
    }
}
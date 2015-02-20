<?php
// src/AppBundle/Admin/DestinationAdmin.php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;

class DestinationAdmin extends Admin
{    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $optionsMiniature = array('label' => 'Miniature: ', 'required' => false, 'label_attr' => array('class' => 'control-miniature'), 'attr' => array('class' => 'destination-miniature'));
        $optionsPhoto1 = array('label' => 'Photo 1: ', 'required' => false, 'label_attr' => array('class' => 'control-photo control-photo1'), 'attr' => array('class' => 'destination-photo'));
        $optionsPhoto2 = array('label' => 'Photo 2: ', 'required' => false, 'label_attr' => array('class' => 'control-photo'), 'attr' => array('class' => 'destination-photo'));
        $optionsPhoto3 = array('label' => 'Photo 3: ', 'required' => false, 'label_attr' => array('class' => 'control-photo'), 'attr' => array('class' => 'destination-photo'));
        $optionsPhoto4 = array('label' => 'Photo 4: ', 'required' => false, 'label_attr' => array('class' => 'control-photo'), 'attr' => array('class' => 'destination-photo'));
        $optionsPhoto5 = array('label' => 'Photo 5: ', 'required' => false, 'label_attr' => array('class' => 'control-photo'), 'attr' => array('class' => 'destination-photo'));
        
        $destination = $this->getSubject();
        
        if ($destination->getMiniatureWebPath()) {$optionsMiniature['help'] = '<img src="' . $destination->getMiniatureWebPath(). '" class="preview-img" />';}
        if ($destination->getPhoto1WebPath()) {$optionsPhoto1['help'] = '<img src="' . $destination->getPhoto1WebPath(). '" class="preview-img" />';}
        if ($destination->getPhoto2WebPath()) {$optionsPhoto2['help'] = '<img src="' . $destination->getPhoto2WebPath(). '" class="preview-img" />';}
        if ($destination->getPhoto3WebPath()) {$optionsPhoto3['help'] = '<img src="' . $destination->getPhoto3WebPath(). '" class="preview-img" />';}
        if ($destination->getPhoto4WebPath()) {$optionsPhoto4['help'] = '<img src="' . $destination->getPhoto4WebPath(). '" class="preview-img" />';}
        if ($destination->getPhoto5WebPath()) {$optionsPhoto5['help'] = '<img src="' . $destination->getPhoto5WebPath(). '" class="preview-img" />';}
        
        $formMapper
            ->add('miniatureFile', 'file', $optionsMiniature)
            ->add('linkgmap', 'text', array('label' => 'Lien google map: ', 'required'=> false, 'label_attr' => array('class' => 'control-lien-google-map'),  'attr' => array('class' => 'destination-lien-google-map')))
            ->add('inclusRecherche', 'checkbox', array('label' => 'Inclure dans la recherche: ', 'attr'=>array('class'=>'destination-inclusrecherche')))    
            ->add('photo1File', 'file', $optionsPhoto1)
            ->add('photo2File', 'file', $optionsPhoto2)
            ->add('photo3File', 'file', $optionsPhoto3)
            ->add('photo4File', 'file', $optionsPhoto4)
            ->add('photo5File', 'file', $optionsPhoto5)
            ->add('translations', 'a2lix_translations', array('attr'=>array('class'=>'test'),
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
                        'infosPratique' => array(         
                            'label' => 'Infos Pratique: ',         
                            'label_attr' => array('class' => 'control-description'),
                            'attr' => array('class' => 'tinymce', 'data-theme' => 'advanced'),
                            'locale_options' => array(
                                'en' => array(
                                    'label' => 'Infos pratique: '
                                ),
                            'required' => false,
                            'class' => 'tinymce'
                            )
                        ),   
                        'translatable_id' => array(   
                            'field_type' => 'hidden'
                        )                
                    )))
                ->add('published', 'checkbox', array('label' => 'Publié: ', 'required'=> false, 'attr'=>array('class'=>'destination-publie')))    
            
        ;
    }
    
    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name', 'translatable_field', array(
                'field'                => 'name',
                'personal_translation' => 'AppBundle\Entity\DestinationTranslation',
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

    public function createQuery($context = 'list') {
        $query = parent::createQuery($context);
    
        return new ProxyQuery($query
            ->leftjoin("AppBundle\Entity\DestinationTranslation", "dt", "WITH", "o.id=dt.translatable_id")
            ->orderBy("dt.name", "ASC"));
    
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
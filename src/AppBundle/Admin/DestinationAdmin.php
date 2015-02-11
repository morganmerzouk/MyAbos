<?php
// src/AppBundle/Admin/DestinationAdmin.php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class DestinationAdmin extends Admin
{    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $optionsMiniature = array('label' => 'Miniature: ', 'required' => false);
        $optionsPhoto1 = array('label' => 'Photo 1: ', 'required' => false);
        $optionsPhoto2 = array('label' => 'Photo 2: ', 'required' => false);
        $optionsPhoto3 = array('label' => 'Photo 3: ', 'required' => false);
        $optionsPhoto4 = array('label' => 'Photo 4: ', 'required' => false);
        $optionsPhoto5 = array('label' => 'Photo 5: ', 'required' => false);
        
        $destination = $this->getSubject();
        
        if ($destination->getMiniatureWebPath()) {$optionsMiniature['help'] = '<img src="' . $destination->getMiniatureWebPath(). '" />';}
        if ($destination->getPhoto1WebPath()) {$optionsPhoto1['help'] = '<img src="' . $destination->getPhoto1WebPath(). '" />';}
        if ($destination->getPhoto2WebPath()) {$optionsPhoto2['help'] = '<img src="' . $destination->getPhoto2WebPath(). '" />';}
        if ($destination->getPhoto3WebPath()) {$optionsPhoto3['help'] = '<img src="' . $destination->getPhoto3WebPath(). '" />';}
        if ($destination->getPhoto4WebPath()) {$optionsPhoto4['help'] = '<img src="' . $destination->getPhoto4WebPath(). '" />';}
        if ($destination->getPhoto5WebPath()) {$optionsPhoto5['help'] = '<img src="' . $destination->getPhoto5WebPath(). '" />';}
        
        $formMapper
            ->add('miniatureFile', 'file', $optionsMiniature)
            ->add('photo1File', 'file', $optionsPhoto1)
            ->add('photo2File', 'file', $optionsPhoto2)
            ->add('photo3File', 'file', $optionsPhoto3)
            ->add('photo4File', 'file', $optionsPhoto4)
            ->add('photo5File', 'file', $optionsPhoto5)
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
                            'attr' => array('class' => 'tinymce', 'data-theme' => 'advanced'),
                            'locale_options' => array(
                                'en' => array(
                                    'label' => 'Description: '
                                ),
                            'required' => false,
                            'class' => 'tinymce'
                            )
                        ),                  
                    )))
            ->add('linkgmap', 'text', array('label' => 'Lien google map: ', 'required'=> false))
            ->add('published', 'checkbox', array('label' => 'Publié: ', 'required'=> false))    
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
            ))
            ->add('published')
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
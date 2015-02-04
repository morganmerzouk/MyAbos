<?php
// src/AppBundle/Admin/SkipperAdmin.php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ItineraireAdmin extends Admin
{    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $optionsMiniature = array('label' => 'Miniature', 'required' => false);
        
        $portDepart = $this->getSubject();
        
        if ($portDepart->getMiniatureWebPath()) {$optionsMiniature['help'] = '<img src="' . $portDepart->getMiniatureWebPath(). '" />';}
        
        $formMapper
            ->add('portDepart', 'entity', array(
                'class'    => 'AppBundle\Entity\PortDepart',
            ))
            ->add('destination', 'entity', array(
                'class'    => 'AppBundle\Entity\Destination',
            ))
            ->add('translations', 'a2lix_translations', array(
                    'fields' => array(                      
                        'description' => array(         
                            'label' => 'Description',
                            'locale_options' => array(
                                'en' => array(
                                    'label' => 'Description'
                                ),
                            'required' => false
                            )
                        ),                  
                    )))
            ->add('miniatureFile', 'file', $optionsMiniature) 
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('portDepart.name', 'translatable_field', array(
                'field'                => 'name',
                'personal_translation' => 'AppBundle\Entity\ItineraireTranslation',
                'property_path'        => 'translations',
            ))
            ->addIdentifier('destination.name', 'translatable_field', array(
                'field'                => 'name',
                'personal_translation' => 'AppBundle\Entity\ItineraireTranslation',
                'property_path'        => 'translations',
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
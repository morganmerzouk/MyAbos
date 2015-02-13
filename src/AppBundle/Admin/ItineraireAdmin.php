<?php
// src/AppBundle/Admin/ItineraireAdmin.php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ItineraireAdmin extends Admin
{    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $optionsMiniature = array('label' => 'Image itinéraire: ', 'required' => false, 'attr' => array('class' => 'itineraire-miniature'));
        
        $portDepart = $this->getSubject();
        
        if ($portDepart->getMiniatureWebPath()) {$optionsMiniature['help'] = '<img src="' . $portDepart->getMiniatureWebPath(). '" class="preview-img" />';}
        
        $formMapper
            ->add('miniatureFile', 'file', $optionsMiniature)
            ->add('portDepart', 'entity', array(
                'class'    => 'AppBundle\Entity\PortDepart',
                'label'    => "Port de départ: "
            ))
            ->add('destination', 'entity', array(
                'class'    => 'AppBundle\Entity\Destination',
                'label'    => "Destination: "
            )) 
            ->add('translations', 'a2lix_translations', array(
                    'fields' => array(                      
                        'description' => array(         
                            'label' => 'Description: ',
                            'attr' => array('class' => 'tinymce', 'data-theme' => 'advanced'),
                            'sonata_field_description' => 'textarea',
                            'locale_options' => array(
                                'en' => array(
                                    'label' => 'Description: '
                                ),
                            'required' => false,
                            
                            )
                        ),                  
                    )))
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('portDepart.name', 'translatable_field', array(
                'field'                => 'name',
                'personal_translation' => 'AppBundle\Entity\ItineraireTranslation',
                'property_path'        => 'translations',
                'label'                => 'Port de départ: '
            ))
            ->addIdentifier('destination.name', 'translatable_field', array(
                'field'                => 'name',
                'personal_translation' => 'AppBundle\Entity\ItineraireTranslation',
                'property_path'        => 'translations',
                'label'                => 'Destination: '
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
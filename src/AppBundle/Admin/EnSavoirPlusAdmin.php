<?php
// src/AppBundle/Admin/EnSavoirPlusAdmin.php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class EnSavoirPlusAdmin extends Admin
{    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $optionsImage1 = array('label' => 'Image 1: ', 'required' => false);
        $optionsPhoto1 = array('label' => 'Photo 1: ', 'required' => false);
        $optionsPhoto2 = array('label' => 'Photo 2: ', 'required' => false);
        $optionsPhoto3 = array('label' => 'Photo 3: ', 'required' => false);
        $optionsPhoto4 = array('label' => 'Photo 4v', 'required' => false);
        $optionsPhoto5 = array('label' => 'Photo 5: ', 'required' => false);
        
        $ensavoirplus = $this->getSubject();
        
        if ($ensavoirplus->getImage1WebPath()) {$optionsImage1['help'] = '<img src="' . $ensavoirplus->getImage1WebPath(). '" />';}
        if ($ensavoirplus->getPhoto1WebPath()) {$optionsPhoto1['help'] = '<img src="' . $ensavoirplus->getPhoto1WebPath(). '" />';}
        if ($ensavoirplus->getPhoto2WebPath()) {$optionsPhoto2['help'] = '<img src="' . $ensavoirplus->getPhoto2WebPath(). '" />';}
        if ($ensavoirplus->getPhoto3WebPath()) {$optionsPhoto3['help'] = '<img src="' . $ensavoirplus->getPhoto3WebPath(). '" />';}
        if ($ensavoirplus->getPhoto4WebPath()) {$optionsPhoto4['help'] = '<img src="' . $ensavoirplus->getPhoto4WebPath(). '" />';}
        if ($ensavoirplus->getPhoto5WebPath()) {$optionsPhoto5['help'] = '<img src="' . $ensavoirplus->getPhoto5WebPath(). '" />';}
        
        $formMapper
            ->add('translations', 'a2lix_translations', array(
                    'fields' => array(                      
                        'name' => array(         
                            'label' => 'Nom: ',
                            'locale_options' => array(
                                'en' => array(
                                    'label' => 'Name: '
                                ),
                            ),'required' => false,
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
                        'libelleLien2' => array(         
                            'label' => 'Nom du lien 2: ',
                            'locale_options' => array(
                                'en' => array(
                                    'label' => 'Name of link 2: '
                                ),
                            'required' => false,
                            )
                        ),      
                        'libelleLien3' => array(         
                            'label' => 'Nom du lien 3: ',
                            'locale_options' => array(
                                'en' => array(
                                    'label' => 'Name of link 3: '
                                ),
                            'required' => false,
                            )
                        ),      
                        'libelleLien4' => array(         
                            'label' => 'Nom du lien 4: ',
                            'locale_options' => array(
                                'en' => array(
                                    'label' => 'Name of link 4: '
                                ),
                            'required' => false,
                            )
                        ),      
                        'libelleLien5' => array(         
                            'label' => 'Nom du lien 5: ',
                            'locale_options' => array(
                                'en' => array(
                                    'label' => 'Name of link 5: '
                                ),
                            'required' => false,
                            )
                        ),
                    )))
            ->add('lien1', 'text', array('label' => 'Lien 1: ', 'required'=> false))
            ->add('image1File', 'file', $optionsImage1)
            ->add('lien2', 'text', array('label' => 'Lien 2: ', 'required'=> false))
            ->add('lien3', 'text', array('label' => 'Lien 3: ', 'required'=> false))
            ->add('lien4', 'text', array('label' => 'Lien 4: ', 'required'=> false))
            ->add('lien5', 'text', array('label' => 'Lien 5: ', 'required'=> false))
            ->add('photo1File', 'file', $optionsPhoto1)
            ->add('photo2File', 'file', $optionsPhoto2)
            ->add('photo3File', 'file', $optionsPhoto3)
            ->add('photo4File', 'file', $optionsPhoto4)
            ->add('photo5File', 'file', $optionsPhoto5)
            ->add('published', 'checkbox', array('label' => 'Publié: ', 'required'=> false))    
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name', 'translatable_field', array(
                'field'                => 'name',
                'personal_translation' => 'AppBundle\Entity\EnSavoirPlusTranslation',
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
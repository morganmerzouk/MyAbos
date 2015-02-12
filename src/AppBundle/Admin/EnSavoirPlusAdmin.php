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
        $optionsImage1 = array('label' => 'Image 1: ', 'required' => false, 'label_attr' => array('class' => 'control-photo'), 'attr' => array('class' => 'ensavoirplus-image1'));
        $optionsPhoto1 = array('label' => 'Photo 1: ', 'required' => false, 'label_attr' => array('class' => 'control-photo control-photo1'), 'attr' => array('class' => 'ensavoirplus-photo'));
        $optionsPhoto2 = array('label' => 'Photo 2: ', 'required' => false, 'label_attr' => array('class' => 'control-photo'), 'attr' => array('class' => 'ensavoirplus-photo'));
        $optionsPhoto3 = array('label' => 'Photo 3: ', 'required' => false, 'label_attr' => array('class' => 'control-photo'), 'attr' => array('class' => 'ensavoirplus-photo'));
        $optionsPhoto4 = array('label' => 'Photo 4: ', 'required' => false, 'label_attr' => array('class' => 'control-photo'), 'attr' => array('class' => 'ensavoirplus-photo'));
        $optionsPhoto5 = array('label' => 'Photo 5: ', 'required' => false, 'label_attr' => array('class' => 'control-photo'), 'attr' => array('class' => 'ensavoirplus-photo'));
        
        $ensavoirplus = $this->getSubject();
        
        if ($ensavoirplus->getImage1WebPath()) {$optionsImage1['help'] = '<img src="' . $ensavoirplus->getImage1WebPath(). '" class="preview-img" />';}
        if ($ensavoirplus->getPhoto1WebPath()) {$optionsPhoto1['help'] = '<img src="' . $ensavoirplus->getPhoto1WebPath(). '" class="preview-img" />';}
        if ($ensavoirplus->getPhoto2WebPath()) {$optionsPhoto2['help'] = '<img src="' . $ensavoirplus->getPhoto2WebPath(). '" class="preview-img" />';}
        if ($ensavoirplus->getPhoto3WebPath()) {$optionsPhoto3['help'] = '<img src="' . $ensavoirplus->getPhoto3WebPath(). '" class="preview-img" />';}
        if ($ensavoirplus->getPhoto4WebPath()) {$optionsPhoto4['help'] = '<img src="' . $ensavoirplus->getPhoto4WebPath(). '" class="preview-img"/>';}
        if ($ensavoirplus->getPhoto5WebPath()) {$optionsPhoto5['help'] = '<img src="' . $ensavoirplus->getPhoto5WebPath(). '" class="preview-img"/>';}
        
        $formMapper
            ->add('image1File', 'file', $optionsImage1)
            ->add('lien1', 'text', array('label' => 'Lien 1: ', 'required'=> false, 'label_attr' => array('class' => 'control-ensavoirplus-lien'), 'attr' => array('class' => 'ensavoirplus-lien ensavoirplus-lien1')))
            ->add('lien2', 'text', array('label' => 'Lien 2: ', 'required'=> false, 'label_attr' => array('class' => 'control-ensavoirplus-lien'), 'attr' => array('class' => 'ensavoirplus-lien')))
            ->add('lien3', 'text', array('label' => 'Lien 3: ', 'required'=> false, 'label_attr' => array('class' => 'control-ensavoirplus-lien'), 'attr' => array('class' => 'ensavoirplus-lien')))
            ->add('lien4', 'text', array('label' => 'Lien 4: ', 'required'=> false, 'label_attr' => array('class' => 'control-ensavoirplus-lien control-ensavoirplus-lien4'), 'attr' => array('class' => 'ensavoirplus-lien')))
            ->add('lien5', 'text', array('label' => 'Lien 5: ', 'required'=> false, 'label_attr' => array('class' => 'control-ensavoirplus-lien'), 'attr' => array('class' => 'ensavoirplus-lien')))
            ->add('photo1File', 'file', $optionsPhoto1)
            ->add('photo2File', 'file', $optionsPhoto2)
            ->add('photo3File', 'file', $optionsPhoto3)
            ->add('photo4File', 'file', $optionsPhoto4)
            ->add('photo5File', 'file', $optionsPhoto5)
            ->add('translations', 'a2lix_translations', array(
                    'fields' => array(                      
                        'libelleLien2' => array(         
                            'label' => 'Nom du lien 2: ',
                            'attr'=>array('class' => 'ensavoirplus-nom-lien'),
                            'label_attr' => array('class' => 'control-ensavoirplus-nom-lien'),
                            'locale_options' => array(
                                'en' => array(
                                    'label' => 'Name of link 2: '
                                ),
                            'required' => false,
                            'class'=>'itineraire-nom-lien'
                            )
                        ),      
                        'libelleLien3' => array(         
                            'label' => 'Nom du lien 3: ',
                            'attr'=>array('class' => 'ensavoirplus-nom-lien'),
                            'label_attr' => array('class' => 'control-ensavoirplus-nom-lien'),
                            'locale_options' => array(
                                'en' => array(
                                    'label' => 'Name of link 3: '
                                ),
                            'required' => false,
                            )
                        ),      
                        'libelleLien4' => array(         
                            'label' => 'Nom du lien 4: ',
                            'attr'=>array('class' => 'ensavoirplus-nom-lien'),
                            'label_attr' => array('class' => 'control-ensavoirplus-nom-lien control-ensavoirplus-nom-lien4'),
                            'locale_options' => array(
                                'en' => array(
                                    'label' => 'Name of link 4: '
                                ),
                            'required' => false,
                            )
                        ),      
                        'libelleLien5' => array(         
                            'label' => 'Nom du lien 5: ',
                            'attr'=>array('class' => 'ensavoirplus-nom-lien'),
                            'label_attr' => array('class' => 'control-ensavoirplus-nom-lien'),
                            'locale_options' => array(
                                'en' => array(
                                    'label' => 'Name of link 5: '
                                ),
                            'required' => false,    
                            )
                        ),
                        'name' => array(         
                            'label' => 'Nom: ',
                            'attr'=>array('class' => 'ensavoirplus-nom-lien'),
                            'label_attr' => array('class'=>'control-ensavoirplus-nom'),
                            'locale_options' => array(
                                'en' => array(
                                    'label' => 'Name: '
                                ),
                            ),'required' => false,
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
                        
                    )))
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
                'label'                => 'Nom: '
            ))
            ->add('published', null, array('label' => 'Publié: '))
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
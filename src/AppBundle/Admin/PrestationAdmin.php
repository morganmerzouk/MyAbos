<?php
// src/AppBundle/Admin/PrestationAdmin.php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;

class PrestationAdmin extends Admin
{    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $optionsIcone= array('label' => 'Icône: ', 'required' => false, 'label_attr' => array('class' => 'control-photo'), 'attr' => array('class' => 'prestation-icone'));
        $optionsPhoto1 = array('label' => 'Photo 1: ', 'required' => false, 'label_attr' => array('class' => 'control-photo control-photo1'), 'attr' => array('class' => 'prestation-photo'));
        $optionsPhoto2 = array('label' => 'Photo 2: ', 'required' => false, 'label_attr' => array('class' => 'control-photo'), 'attr' => array('class' => 'prestation-photo'));
        $optionsPhoto3 = array('label' => 'Photo 3: ', 'required' => false, 'label_attr' => array('class' => 'control-photo'), 'attr' => array('class' => 'prestation-photo'));
        $optionsPhoto4 = array('label' => 'Photo 4: ', 'required' => false, 'label_attr' => array('class' => 'control-photo'), 'attr' => array('class' => 'prestation-photo'));
        $optionsPhoto5 = array('label' => 'Photo 5: ', 'required' => false, 'label_attr' => array('class' => 'control-photo'), 'attr' => array('class' => 'prestation-photo'));
        
        $prestation = $this->getSubject();
        
        if ($prestation->getIconeWebPath()) {$optionsIcone['help'] = '<img src="' . $prestation->getIconeWebPath(). '" class="preview-img" />';}
        if ($prestation->getPhoto1WebPath()) {$optionsPhoto1['help'] = '<img src="' . $prestation->getPhoto1WebPath(). '" class="preview-img" />';}
        if ($prestation->getPhoto2WebPath()) {$optionsPhoto2['help'] = '<img src="' . $prestation->getPhoto2WebPath(). '" class="preview-img" />';}
        if ($prestation->getPhoto3WebPath()) {$optionsPhoto3['help'] = '<img src="' . $prestation->getPhoto3WebPath(). '" class="preview-img" />';}
        if ($prestation->getPhoto4WebPath()) {$optionsPhoto4['help'] = '<img src="' . $prestation->getPhoto4WebPath(). '" class="preview-img"/>';}
        if ($prestation->getPhoto5WebPath()) {$optionsPhoto5['help'] = '<img src="' . $prestation->getPhoto5WebPath(). '" class="preview-img"/>';}
        
        $formMapper
            ->add('iconeFile', 'file', $optionsIcone)
            ->add('photo1File', 'file', $optionsPhoto1)
            ->add('photo2File', 'file', $optionsPhoto2)
            ->add('photo3File', 'file', $optionsPhoto3)
            ->add('photo4File', 'file', $optionsPhoto4)
            ->add('photo5File', 'file', $optionsPhoto5)
            ->add('translations', 'a2lix_translations', array(
                    'fields' => array(                      
                        'name' => array(         
                            'label' => 'Nom: ',
                            'attr'=>array('class' => 'prestation-nom'),
                            'label_attr' => array('class'=>'control-prestation-nom'),
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
                        'translatable_id' => array(   
                            'field_type' => 'hidden'
                        )        
                        
                    )))
            ->add('published', 'checkbox', array('label' => 'Publié: ', 'required'=> false))    
        ;
    }

    public function createQuery($context = 'list') {
        $query = parent::createQuery($context);
    
        return new ProxyQuery($query
            ->leftjoin("AppBundle\Entity\PrestationTranslation", "pt", "WITH", "o.id=pt.translatable_id")
            ->orderBy("pt.name", "ASC"));
    }
    
    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name', 'translatable_field', array(
                'field'                => 'name',
                'personal_translation' => 'AppBundle\Entity\PrestationTranslation',
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
    
    
    public function prePersist($prestation) {
        $this->saveFile($prestation);
    }
    
    public function preUpdate($prestation) {
        $this->saveFile($prestation);
    }
    
    public function saveFile($prestation) {
        $basepath = $this->getRequest()->getBasePath();
        $prestation->upload($prestation);
    }
}
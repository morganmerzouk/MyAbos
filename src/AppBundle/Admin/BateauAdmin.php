<?php
// src/AppBundle/Admin/BateauAdmin.php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;

class BateauAdmin extends Admin
{    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $optionsMiniature = array('label' => 'Miniature: ', 'required' => false, 'label_attr' => array('class' => 'control-miniature'), 'attr' => array('class' => 'bateau-miniature'));
        $optionsPhotoVoile = array('label' => 'Voile: ', 'required' => false, 'label_attr' => array('class' => 'control-photo control-photo1'), 'attr' => array('class' => 'bateau-photo'));
        $optionsPhotoMouillage = array('label' => 'Mouillage: ', 'required' => false, 'label_attr' => array('class' => 'control-photo'), 'attr' => array('class' => 'bateau-photo'));
        $optionsPhotoCockpit = array('label' => 'Cockpit: ', 'required' => false, 'label_attr' => array('class' => 'control-photo'), 'attr' => array('class' => 'bateau-photo'));
        $optionsPhotoCarre = array('label' => 'Carre: ', 'required' => false, 'label_attr' => array('class' => 'control-photo'), 'attr' => array('class' => 'bateau-photo'));
        $optionsPhotoCabine = array('label' => 'Cabine: ', 'required' => false, 'label_attr' => array('class' => 'control-photo'), 'attr' => array('class' => 'bateau-photo'));
        
        $bateau = $this->getSubject();
        
        if ($bateau->getMiniatureWebPath()) {$optionsMiniature['help'] = '<img src="' . $bateau->getMiniatureWebPath(). '" class="preview-img" />';}
        if ($bateau->getPhotoVoileWebPath()) {$optionsPhotoVoile['help'] = '<img src="' . $bateau->getPhotoVoileWebPath(). '" class="preview-img" />';}
        if ($bateau->getPhotoMouillageWebPath()) {$optionsPhotoMouillage['help'] = '<img src="' . $bateau->getPhotoMouillageWebPath(). '" class="preview-img" />';}
        if ($bateau->getPhotoCockpitWebPath()) {$optionsPhotoCockpit['help'] = '<img src="' . $bateau->getPhotoCockpitWebPath(). '" class="preview-img" />';}
        if ($bateau->getPhotoCarreWebPath()) {$optionsPhotoCarre['help'] = '<img src="' . $bateau->getPhotoCarreWebPath(). '" class="preview-img"/>';}
        if ($bateau->getPhotoCabineWebPath()) {$optionsPhotoCabine['help'] = '<img src="' . $bateau->getPhotoCabineWebPath(). '" class="preview-img"/>';}
        
        $formMapper
            ->add('miniatureFile', 'file', $optionsMiniature)
            ->add('photoVoileFile', 'file', $optionsPhotoVoile)
            ->add('photoMouillageFile', 'file', $optionsPhotoMouillage)
            ->add('photoCockpitFile', 'file', $optionsPhotoCockpit)
            ->add('photoCarreFile', 'file', $optionsPhotoCarre)
            ->add('photoCabineFile', 'file', $optionsPhotoCabine)
            ->add('translations', 'a2lix_translations', array(
                    'fields' => array(                      
                        'name' => array(         
                            'label' => 'Nom: ',
                            'attr'=>array('class' => 'bateau-nom'),
                            'label_attr' => array('class'=>'control-bateau-nom'),
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
                        'longueur' => array(         
                            'label' => 'Longueur: ',             
                            'label_attr' => array('class' => 'control-bateau-longueur'),               
                            'attr' => array('class' => 'bateau-longueur'),
                            'locale_options' => array(
                                'en' => array(
                                    'label' => 'Length: '
                                ),
                            'required' => false,
                            )
                        ),              
                        'largeur' => array(         
                            'label' => 'Largeur: ',             
                            'label_attr' => array('class' => 'control-bateau-largeur'),               
                            'attr' => array('class' => 'bateau-largeur'),
                            'locale_options' => array(
                                'en' => array(
                                    'label' => 'Width: '
                                ),
                            'required' => false,
                            )
                        ),              
                        'moteur' => array(         
                            'label' => 'Moteur(s): ',             
                            'label_attr' => array('class' => 'control-bateau-moteur'),               
                            'attr' => array('class' => 'bateau-moteur'),
                            'locale_options' => array(
                                'en' => array(
                                    'label' => 'Engine: '
                                ),
                            'required' => false,
                            )
                        ),     
                        'equipementCuisine' => array(         
                            'label' => 'Equipement en cuisine: ',             
                            'label_attr' => array('class' => 'control-bateau-equipement'),               
                            'attr' => array('class' => 'bateau-equipement'),
                            'locale_options' => array(
                                'en' => array(
                                    'label' => 'Galley Equipments: '
                                ),
                            'required' => false,
                            )
                        ),                       
                        'loisir' => array(         
                            'label' => 'Loisirs: ',             
                            'label_attr' => array('class' => 'control-bateau-loisir'),               
                            'attr' => array('class' => 'bateau-loisir'),
                            'locale_options' => array(
                                'en' => array(
                                    'label' => 'Entertainment: '
                                ),
                            'required' => false,
                            )
                        ),    
                        'energie' => array(         
                            'label' => 'Energie: ',             
                            'label_attr' => array('class' => 'control-bateau-energie'),               
                            'attr' => array('class' => 'bateau-energie'),
                            'locale_options' => array(
                                'en' => array(
                                    'label' => 'Energy supplies: '
                                ),
                            'required' => false,
                            )
                        ),      
                        'canot' => array(         
                            'label' => 'Canot: ',             
                            'label_attr' => array('class' => 'control-bateau-canot'),               
                            'attr' => array('class' => 'bateau-canot'),
                            'locale_options' => array(
                                'en' => array(
                                    'label' => 'Dinghy: '
                                ),
                            'required' => false,
                            )
                        ), 
                        'jouet' => array(         
                            'label' => 'Jouet: ',             
                            'label_attr' => array('class' => 'control-bateau-jouet'),               
                            'attr' => array('class' => 'bateau-jouet'),
                            'locale_options' => array(
                                'en' => array(
                                    'label' => 'Toys available: '
                                ),
                            'required' => false,
                            )
                        ),         
                        'autre' => array(         
                            'label' => 'Autres informations: ',             
                            'label_attr' => array('class' => 'control-bateau-autre'),               
                            'attr' => array('class' => 'bateau-autre'),
                            'locale_options' => array(
                                'en' => array(
                                    'label' => 'Additional infos: '
                                ),
                            'required' => false,
                            )
                        ),                                                  
                        
                    )))
                
            ->add('nbCabine', 'choice', array('label' => 'Nb de cabine: ',
                'label_attr' => array('class' => 'control-bateau-nbcabine'),    
                'choice_list' => $this->loadChoiceList("cabine"),
                'expanded' => true,
                'attr' => array("class"=>"bateau-list-radio"),
                'data' => 1
            ))
            ->add('nbDouche', 'choice', array('label' => 'Nb de douche: ',
                'label_attr' => array('class' => 'control-bateau-nbdouche'),    
                'choice_list' => $this->loadChoiceList("douche"),
                'expanded' => true,
                'attr' => array("class"=>"bateau-list-radio"),
                'data' => 1
            ))
            ->add('nbEquipier', 'choice', array('label' => 'Nb d\'équipier: ',
                'label_attr' => array('class' => 'control-bateau-nbequipier'),    
                'choice_list' => $this->loadChoiceList("equipier"),
                'expanded' => true,
                'attr' => array("class"=>"bateau-list-radio"),
                'data' => 1
            ))
            ->add('skipper', 'entity', array(
                'class'    => 'AppBundle\Entity\Skipper',
                'label'  => 'Skipper associé',
                'label_attr' => array('class' => 'control-bateau-skipper'),
            ))
            ->add('type', 'choice', array('label' => 'Type: ',
                    'expanded'=>true,
                    'data'=>1,
                    'label_attr' => array('class' => 'control-bateau-type'),
                    'choice_list'=> $this->loadChoiceList("type"),
                    'attr' => array("class"=>"bateau-list-radio")))
            ->add('published', 'checkbox', array('label' => 'Publié: ', 'required'=> false))    
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name', 'translatable_field', array(
                'field'                => 'name',
                'personal_translation' => 'AppBundle\Entity\BateauTranslation',
                'property_path'        => 'translations',
                'label'                => 'Nom: '
            ))
            ->addIdentifier('skipper.name', 'translatable_field', array(
                'field'                => 'name',
                'personal_translation' => 'AppBundle\Entity\BateauTranslation',
                'property_path'        => 'translations',
                'label'                => 'Skipper associé: '
            ))
            ->add('published', null, array('label' => 'Publié: '))
        ;
    }
    
     protected function loadChoiceList($type) {
        if($type=="cabine"){
            $item = array(
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6'
                );
        }
        elseif($type=="type"){$item = array('Monohull','Catamaran');}
        elseif($type=="equipier"){
            $item = array(
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4'
                );
        }
        elseif($type=="douche"){
            $item = array(
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4'
                );
         }
        
        $choices = new SimpleChoiceList($item);
    
        return $choices;
    }
    
    public function setBaseRouteName($baseRouteName)
    {
        $this->baseRouteName = $baseRouteName;
    }
    
    public function setBaseRoutePattern($baseRoutePattern)
    {
        $this->baseRoutePattern = $baseRoutePattern;
    }
    
    
    public function prePersist($bateau) {
        $this->saveFile($bateau);
    }
    
    public function preUpdate($bateau) {
        $this->saveFile($bateau);
    }
    
    public function saveFile($bateau) {
        $basepath = $this->getRequest()->getBasePath();
        $bateau->upload($bateau);
    }
}
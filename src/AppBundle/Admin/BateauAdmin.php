<?php
// src/AppBundle/Admin/BateauAdmin.php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Sonata\AdminBundle\Datagrid\DatagridMapper;


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
            ->add('name', 'text', array('label' => 'Nom: ', 'required'=> false, 'label_attr' => array('class' => 'control-name'),  'attr' => array('class' => 'skipper-name')))
            ->add('photoVoileFile', 'file', $optionsPhotoVoile)
            ->add('photoMouillageFile', 'file', $optionsPhotoMouillage)
            ->add('photoCockpitFile', 'file', $optionsPhotoCockpit)
            ->add('photoCarreFile', 'file', $optionsPhotoCarre)
            ->add('photoCabineFile', 'file', $optionsPhotoCabine)
            ->add('translations', 'a2lix_translations', array(
                    'fields' => array(       
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
            ->add('longueur', 'text', array('label' => 'Longueur: ', 'required'=> false, 'label_attr' => array('class' => 'control-longueur'),  'attr' => array('class' => 'bateau-longueur')))
            ->add('largeur', 'text', array('label' => 'Largeur: ', 'required'=> false, 'label_attr' => array('class' => 'control-largeur'),  'attr' => array('class' => 'bateau-largeur')))
            ->add('tirantdeau', 'text', array('label' => 'Tirant d\'eau: ', 'required'=> false, 'label_attr' => array('class' => 'control-tirantdeau'),  'attr' => array('class' => 'bateau-tirantdeau')))
            ->add('surfaceGrandVoile', 'text', array('label' => 'Surface Grand voile: ', 'required'=> false, 'label_attr' => array('class' => 'control-surfacegrandvoile'),  'attr' => array('class' => 'bateau-surfacegrandvoile')))
            ->add('moteur', 'text', array('label' => 'Moteur: ', 'required'=> false, 'label_attr' => array('class' => 'control-moteur'),  'attr' => array('class' => 'bateau-moteur')))
            ->add('reservoirCarburant', 'text', array('label' => 'Réservoir carburant: ', 'required'=> false, 'label_attr' => array('class' => 'control-reservoircarburant'),  'attr' => array('class' => 'bateau-reservoircarburant')))
            ->add('reservoirEau', 'text', array('label' => 'Réservoir d\'eau: ', 'required'=> false, 'label_attr' => array('class' => 'control-reservoireau'),  'attr' => array('class' => 'bateau-reservoireau')))
            
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
                'attr' => array("class"=>"bateau-list-radio")
            ))
            ->add('type', 'choice', array('label' => 'Type: ',
                    'expanded'=>true,
                    'data'=>1,
                    'label_attr' => array('class' => 'control-bateau-type'),
                    'choice_list'=> $this->loadChoiceList("type"),
                    'attr' => array("class"=>"bateau-list-radio")))
            ->add('inclusprixEquipage', 'doctrine_orm_callback', array(
                                    'callback'   => array($this, 'getInclusPrixEquipage')))
            ->add('published', 'checkbox', array('label' => 'Publié: ', 'required'=> false))    
        ;
    }

    public function getInclusPrixEquipage($queryBuilder, $alias, $field, $value)
    {
        if (!$value) {
            return;
        }
    
        $queryBuilder->leftJoin(sprintf('%s.inclusprix', $alias), 'c');
        $queryBuilder->andWhere('c.categorie = :categorie');
        $queryBuilder->setParameter('categorie', "Equipage");
    
        return true;
    }
    
    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name', null, array('label' => 'Nom: ', 'sortable' => true))
            ->add('published', null, array('label' => 'Publié: '))
            ->add('_action', 'actions',
                array(
                    'actions' => array(
                        'edit' => array(),
                        'delete' => array()
                    )
                ))
        ;
        ;
    }
    
    protected $datagridValues = array(
        '_page' => 1,
        '_sort_order' => 'ASC',
        '_sort_by' => 'name',
    );
    
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
        ->add('name', null, array('label' => 'Nom: ', 'attr'=>array('class'=>'control-name')));
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
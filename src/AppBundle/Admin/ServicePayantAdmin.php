<?php
// src/AppBundle/Admin/ServicePayantAdmin.php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;

class ServicePayantAdmin extends Admin
{    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $optionsMiniature = array('label' => 'Miniature: ', 'required' => false, 'label_attr' => array('class' => 'control-miniature'), 'attr' => array('class' => 'optionpayante-miniature'));
        
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
                    )))
                ->add('prestation', 'entity', array(
                    'class'    => 'AppBundle\Entity\Prestation',
                    'label'  => 'Rattachement à une prestation',
                    'label_attr' => array('class' => 'control-optionpayante-prestation'),
                ))
                ->add('categorie', 'choice', array('label' => 'Catégorie d\'option payante: ',
                    'label_attr' => array('class' => 'control-optionpayante-categorie'),    
                    'choice_list' => $this->loadChoiceList("categorie"),
                    'expanded' => true,
                    'attr' => array("class"=>"inclusprix-list-radio"),
                    'data' => 1
                ))
                ->add('bateau', 'entity', array(
                    'class'    => 'AppBundle\Entity\Bateau',
                    'label'  => 'Rattachement à un bateau spécifique',
                    'label_attr' => array('class' => 'control-optionpayante-bateau'),
                ))
                ->add('fraisSupplementaires', 'text', array(
                    'label'  => 'Frais supplémentaires: ',
                    'label_attr' => array('class' => 'control-optionpayante-frais'),
                ))
                ->add('devise', 'choice', array('label' => 'Devise: ',
                    'label_attr' => array('class' => 'control-optionpayante-categorie'),    
                    'choice_list' => $this->loadChoiceList("devise"),
                    'expanded' => true,
                    'attr' => array("class"=>"optionpayante-list-radio"),
                    'data' => 1
                ))
                ->add('published', 'checkbox', array('label' => 'Publié: ', 'required'=> false, 'attr'=>array('class'=>'optionpayante-publie')))    
            
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name', 'translatable_field', array(
                'field'                => 'name',
                'personal_translation' => 'AppBundle\Entity\ItineraireTranslation',
                'property_path'        => 'translations',
                'label'                => 'Nom: ',
                'editable'             => true
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
                    'Equipiers supplémentaires' => 'Equipiers supplémentaires',
                    'Service d\'avitaillement supplémentaire' => 'Service d\'avitaillement supplémentaire',
                    'Autres prestations disponibles à bord' => 'Autres prestations disponibles à bord',
                    'Equipements supplémentaires' => 'Equipements supplémentaires',
                    'Activités supplémentaires' => 'Activités supplémentaires',
                    'Cours de kitesurf' => 'Cours de kitesurf'
                );
        } elseif($type="devise") {
            $item = array("€" => "€", "$" => "$");
        }
        
        $choices = new SimpleChoiceList($item);
    
        return $choices;
    }
}
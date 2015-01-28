<?php
// src/AppBundle/Admin/SkipperAdmin.php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;

class SkipperAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', 'text', array('label' => 'Nom', 'required'=> false))
            ->add('email', 'text', array('label' => 'Email', 'required'=> false))
            ->add('description', 'text', array('label' => 'Description', 'required'=> false))
            ->add('yearsSailing', 'choice', array('label' => 'Nombre d\'années de navigation', 'required'=> false,
                'choice_list' => $this->loadChoiceList()
            ))
            ->add('professionalSince', 'text', array('label' => 'Professionel depuis', 'required'=> false))
            ->add('certificationDate', 'text', array('label' => 'Date de certification', 'required'=> false))
            ->add('yearsSailingCarribean', 'choice', array('label' => 'Nombre d\'années de navigation dans les Caraïbes', 'required'=> false,
                'choice_list' => $this->loadChoiceList()
            ))
            ->add('yearsKiteSurfing', 'choice', array('label' => 'Nombre d\'années de KiteSurfing', 'required'=> false,
                'choice_list' => $this->loadChoiceList()
            ))
            ->add('yearsKiteCruise', 'choice', array('label' => 'Nombre d\'années de croisière', 'required'=> false,
                'choice_list' => $this->loadChoiceList()
            ))
            ->add('kitesurfInstructorSince', 'choice', array('label' => 'Instructeur de Kitesurf depuis', 'required'=> false,
                'choice_list' => $this->loadYearsList()
            ))
            ->add('kitesurfCertificationDate', 'text', array('label' => 'Date de certification de Kitesurf', 'required'=> false))

            ->add('translations', 'a2lix_translations', array(
                    'fields' => array(                      
                        'otherCertifications' => array(         
                            'label' => 'Autres certifications',
                            'locale_options' => array(
                                'en' => array(
                                    'label' => 'Other certifications'
                                ),
                            'required' => false
                            )
                        ),                  
                        'hobbies' => array(         
                            'label' => 'Hobbies',
                            'locale_options' => array(
                                'en' => array(
                                    'label' => 'Hobbies'
                                ),
                            'required' => false
                            )
                        ),                  
                        'greatestQualities' => array(         
                            'label' => 'Qualités',
                            'locale_options' => array(
                                'en' => array(
                                    'label' => 'Greatest qualities'
                                ),
                            'required' => false
                            )
                        )
                    )))
            ->add('avatarFile', 'file', array('label' => 'Avatar', 'required' => false))
            ->add('rank', 'integer', array('label' => 'Ordre', 'required'=> false))
            ->add('published', 'checkbox', array('label' => 'Publié', 'required'=> false))    
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('email')
            ->add('avatar')
            ->add('order')
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
    
    public function prePersist($avatar) {
        $this->saveFile($avatar);
    }
    
    public function preUpdate($avatar) {
        $this->saveFile($avatar);
    }
    
    public function saveFile($avatar) {
        $basepath = $this->getRequest()->getBasePath();
        $avatar->upload($basepath);
    }

    protected function loadChoiceList() {
        $years = array(
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5',
            '6' => '6',
            '7' => '7',
            '8' => '8',
            '9' => '9',
            '10' => '10',
            '11' => '11',
            '12' => '12',
            '13' => '13',
            '14' => '14',
            '15' => '15',
            '20' => '20',
            '25' => '25',
            '30' => '30',
            '35' => '35',
            '40' => '40',
            '45' => '45',
            '50' => '50'
        );
        $choices = new SimpleChoiceList($years);
    
        return $choices;
    }

    protected function loadYearsList() {
        $years = array(
            '2000' => '2000',
            '2001' => '2001',
            '2002' => '2002',
            '2003' => '2003',
            '2004' => '2004',
            '2005' => '2005',
            '2006' => '2006',
            '2007' => '2007',
            '2008' => '2008',
            '2009' => '2009',
            '2010' => '2010',
            '2011' => '2011',
            '2012' => '2012',
            '2013' => '2013',
            '2014' => '2014',
            '2015' => '2015',
        );
        $choices = new SimpleChoiceList($years);
    
        return $choices;
    }
    
}
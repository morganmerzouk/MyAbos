<?php
// src/AppBundle/Admin/SkipperAdmin.php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class SkipperAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('translations', 'a2lix_translations', array(
                'by_reference' => false,
                'locales' => array('fr', 'en')))
            ->add('name', 'text', array('label' => 'Nom'))
            ->add('email', 'text', array('label' => 'Email'))
            ->add('description', 'text', array('label' => 'Description'))
            ->add('yearsSailing', 'text', array('label' => 'Years sailing'))
            ->add('professionalSince', 'text', array('label' => 'Professional since'))
            ->add('certificationDate', 'text', array('label' => 'certificationDate'))
            ->add('yearsSailingCarribean', 'text', array('label' => 'yearsSailingCarribean'))
            ->add('yearsKiteSurfing', 'text', array('label' => 'yearsKiteSurfing'))
            ->add('yearsKiteCruise', 'text', array('label' => 'yearsKiteCruise'))
            ->add('kitesurfInstructorSince', 'text', array('label' => 'kitesurfInstructorSince'))
            ->add('kitesurfCertificationDate', 'text', array('label' => 'kitesurfCertificationDate'))
            ->add('otherCertification', 'text', array('label' => 'otherCertification'))
            ->add('hobbies', 'text', array('label' => 'hobbies'))
            ->add('languagesSpoken', 'text', array('label' => 'languagesSpoken'))
            ->add('greatestQualities', 'text', array('label' => 'greatestQualities'))
            ->add('avatar', 'text', array('label' => 'avatar'))
            ->add('rank', 'integer', array('label' => 'order'))
            ->add('published', 'checkbox', array('label' => 'published'))
            
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
}
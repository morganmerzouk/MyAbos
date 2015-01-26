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
            ->add('translations', 'a2lix_translations')
            ->add('name', 'text', array('label' => 'Nom', 'required'=> false))
            ->add('email', 'text', array('label' => 'Email', 'required'=> false))
            ->add('description', 'text', array('label' => 'Description', 'required'=> false))
            ->add('yearsSailing', 'text', array('label' => 'Years sailing', 'required'=> false))
            ->add('professionalSince', 'text', array('label' => 'Professional since', 'required'=> false))
            ->add('certificationDate', 'text', array('label' => 'certificationDate', 'required'=> false))
            ->add('yearsSailingCarribean', 'text', array('label' => 'yearsSailingCarribean', 'required'=> false))
            ->add('yearsKiteSurfing', 'text', array('label' => 'yearsKiteSurfing', 'required'=> false))
            ->add('yearsKiteCruise', 'text', array('label' => 'yearsKiteCruise', 'required'=> false))
            ->add('kitesurfInstructorSince', 'text', array('label' => 'kitesurfInstructorSince', 'required'=> false))
            ->add('kitesurfCertificationDate', 'text', array('label' => 'kitesurfCertificationDate', 'required'=> false))
            ->add('otherCertifications', 'text', array('label' => 'otherCertification', 'required'=> false))
            ->add('hobbies', 'text', array('label' => 'hobbies', 'required'=> false))
            ->add('languagesSpoken', 'text', array('label' => 'languagesSpoken', 'required'=> false))
            ->add('greatestQualities', 'text', array('label' => 'greatestQualities', 'required'=> false))
            ->add('avatarFile', 'file', array('required' => false))
            ->add('rank', 'integer', array('label' => 'rank', 'required'=> false))
            ->add('published', 'checkbox', array('label' => 'published', 'required'=> false))
            
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
}
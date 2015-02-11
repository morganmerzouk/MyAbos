<?php
// src/AppBundle/Admin/SkipperAdmin.php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;

class SkipperAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $optionsAvatar = array( 'label' => 'Avatar: ', 'required' => false, 'label_attr' => array('class' => 'control-photo'), 'attr' => array('class' => 'skipper-avatar'));
        $optionsPhoto1 = array('label' => 'Photo 1: ', 'required' => false, 'label_attr' => array('class' => 'control-photo'), 'attr' => array('class' => 'skipper-photo1'));
        $optionsPhoto2 = array('label' => 'Photo 2: ', 'required' => false, 'label_attr' => array('class' => 'control-photo'), 'attr' => array('class' => 'skipper-photo2'));
        $optionsPhoto3 = array('label' => 'Photo 3: ', 'required' => false, 'label_attr' => array('class' => 'control-photo'), 'attr' => array('class' => 'skipper-photo3'));
        $optionsPhoto4 = array('label' => 'Photo 4: ', 'required' => false, 'label_attr' => array('class' => 'control-photo'), 'attr' => array('class' => 'skipper-photo4'));
        $optionsPhoto5 = array('label' => 'Photo 5: ', 'required' => false, 'label_attr' => array('class' => 'control-photo'), 'attr' => array('class' => 'skipper-photo5'));
        
        $skipper = $this->getSubject();
        
        if ($skipper->getAvatarWebPath()) {$optionsAvatar['help'] = '<img src="' . $skipper->getAvatarWebPath(). '" />';}
        if ($skipper->getPhoto1WebPath()) {$optionsPhoto1['help'] = '<img src="' . $skipper->getPhoto1WebPath(). '" />';}
        if ($skipper->getPhoto2WebPath()) {$optionsPhoto2['help'] = '<img src="' . $skipper->getPhoto2WebPath(). '" />';}
        if ($skipper->getPhoto3WebPath()) {$optionsPhoto3['help'] = '<img src="' . $skipper->getPhoto3WebPath(). '" />';}
        if ($skipper->getPhoto4WebPath()) {$optionsPhoto4['help'] = '<img src="' . $skipper->getPhoto4WebPath(). '" />';}
        if ($skipper->getPhoto5WebPath()) {$optionsPhoto5['help'] = '<img src="' . $skipper->getPhoto5WebPath(). '" />';}


        $formMapper
            ->add('avatarFile', 'file', $optionsAvatar)
            ->add('name', 'text', array('label' => 'Nom: ', 'required'=> false, 'label_attr' => array('class' => 'control-name'),  'attr' => array('class' => 'skipper-name') ))
            ->add('email', 'text', array('label' => 'Email: ', 'required'=> false, 'label_attr' => array('class' => 'control-email'),  'attr' => array('class' => 'skipper-email')))
            ->add('photo1File', 'file', $optionsPhoto1)
            ->add('photo2File', 'file', $optionsPhoto2)
            ->add('photo3File', 'file', $optionsPhoto3)
            ->add('photo4File', 'file', $optionsPhoto4)
            ->add('photo5File', 'file', $optionsPhoto5)
            ->add('description', 'textarea', array('required' => false, 'label_attr' => array('class' => 'control-description'), 'attr' => array('class' => 'tinymce', 'data-theme' => 'advanced')))
            ->add('yearsSailing', 'choice', array('label' => 'Nombre d\'années de navigation: ', 'required'=> false, 'label_attr' => array('class' => 'control-annee-navigation'),
                'choice_list' => $this->loadChoiceList()
            ))
            ->add('professionalSince', 'text', array('label' => 'Professionel depuis: ', 'required'=> false, 'attr' => array('class' => 'skipper-professional-since')))
            ->add('certificationDate', 'text', array('label' => 'Date de certification: ', 'required'=> false, 'attr' => array('class' => 'skipper-date-certification')))
            ->add('languagesSpoken', 'choice', array('label' => 'Langues parlées: ', 'choice_list' => $this->loadLanguagesList(), 'multiple' => true, 'required' => false, 'label_attr' => array('class' => 'control-languages-spoken')))
            ->add('kitesurfCertificationDate', 'text', array('label' => 'Date de certification de Kitesurf: ', 'required'=> false, 'attr' => array('class' => 'skipper-kitesurf-certification-date'), 'label_attr' => array('class' => 'control-kitesurf-certification-date')))
            ->add('yearsSailingCarribean', 'choice', array('label' => 'Nombre d\'années de navigation dans les Caraïbes: ', 'required'=> false,  'label_attr' => array('class' => 'control-annee-navigation-caraibes'), 'attr' => array('class' => 'skipper-annee-navigation-caraibes'),
                'choice_list' => $this->loadChoiceList()
            ))
            ->add('yearsKiteSurfing', 'choice', array('label' => 'Nombre d\'années de KiteSurfing: ', 'required'=> false, 'label_attr' => array('class' => 'control-annee-kitesurfing'),
                'choice_list' => $this->loadChoiceList()
            ))
            ->add('yearsKiteCruise', 'choice', array('label' => 'Nombre d\'années de croisière: ', 'required'=> false,
                'choice_list' => $this->loadChoiceList()
            ))
            ->add('kitesurfInstructorSince', 'choice', array('label' => 'Instructeur de Kitesurf depuis: ', 'required'=> false,
                'choice_list' => $this->loadYearsList()
            ))
            ->add('translations', 'a2lix_translations', array(
                    'fields' => array(                      
                        'otherCertifications' => array(         
                            'label' => 'Autres certifications: ',
                            'locale_options' => array(
                                'en' => array(
                                    'label' => 'Other certifications: '
                                ),
                            'required' => false
                            )
                        ),                  
                        'hobbies' => array(         
                            'label' => 'Hobbies: ',
                            'locale_options' => array(
                                'en' => array(
                                    'label' => 'Hobbies: '
                                ),
                            'required' => false
                            )
                        ),                  
                        'greatestQualities' => array(         
                            'label' => 'Qualités: ',
                            'locale_options' => array(
                                'en' => array(
                                    'label' => 'Greatest qualities: '
                                ),
                            'required' => false

                            )
                        )
                    )))
                ->add('published', 'checkbox', array('label' => 'Publié: ', 'required'=> false))   
            
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('email')
            ->add('avatar')
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
    
    public function prePersist($skipper) {
        $this->saveFile($skipper);
    }
    
    public function preUpdate($skipper) {
        $this->saveFile($skipper);
    }
    
    public function saveFile($skipper) {
        $basepath = $this->getRequest()->getBasePath();
        $skipper->upload($basepath);
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
    
    protected function loadLanguagesList() {
        $languages = array(
            'Francais' => 'Francais',
            'Anglais' => 'Anglais',
            'Allemand' => 'Allemand',
            'Italien' => 'Italien',
            'Espagnol' => 'Espagnol',
            'Danois' => 'Danois',
            'Grec' => 'Grec',
            'Portugais' => 'Portugais',
        );
        $choices = new SimpleChoiceList($languages);
    
        return $choices;
    }
    
}
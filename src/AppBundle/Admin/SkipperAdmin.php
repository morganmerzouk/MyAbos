<?php
// src/AppBundle/Admin/SkipperAdmin.php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

class SkipperAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $optionsAvatar = array('label' => 'Avatar: ', 'required' => false, 'label_attr' => array('class' => 'control-photo'), 'attr' => array('class' => 'skipper-avatar'));
        $optionsPhoto1 = array('label' => 'Photo 1: ', 'required' => false, 'label_attr' => array('class' => 'control-photo'), 'attr' => array('class' => 'skipper-photo'));
        $optionsPhoto2 = array('label' => 'Photo 2: ', 'required' => false, 'label_attr' => array('class' => 'control-photo'), 'attr' => array('class' => 'skipper-photo'));
        $optionsPhoto3 = array('label' => 'Photo 3: ', 'required' => false, 'label_attr' => array('class' => 'control-photo'), 'attr' => array('class' => 'skipper-photo'));
        $optionsPhoto4 = array('label' => 'Photo 4: ', 'required' => false, 'label_attr' => array('class' => 'control-photo'), 'attr' => array('class' => 'skipper-photo'));
        $optionsPhoto5 = array('label' => 'Photo 5: ', 'required' => false, 'label_attr' => array('class' => 'control-photo'), 'attr' => array('class' => 'skipper-photo'));
        
        $skipper = $this->getSubject();
        
        if ($skipper->getAvatarWebPath()) {$optionsAvatar['help'] = '<img src="' . $skipper->getAvatarWebPath(). '" class="preview-img" />';}
        if ($skipper->getPhoto1WebPath()) {$optionsPhoto1['help'] = '<img src="' . $skipper->getPhoto1WebPath(). '" class="preview-img" />';}
        if ($skipper->getPhoto2WebPath()) {$optionsPhoto2['help'] = '<img src="' . $skipper->getPhoto2WebPath(). '" class="preview-img" />';}
        if ($skipper->getPhoto3WebPath()) {$optionsPhoto3['help'] = '<img src="' . $skipper->getPhoto3WebPath(). '" class="preview-img" />';}
        if ($skipper->getPhoto4WebPath()) {$optionsPhoto4['help'] = '<img src="' . $skipper->getPhoto4WebPath(). '" class="preview-img" />';}
        if ($skipper->getPhoto5WebPath()) {$optionsPhoto5['help'] = '<img src="' . $skipper->getPhoto5WebPath(). '" class="preview-img" />';}


        $formMapper
            ->add('avatarFile', 'file', $optionsAvatar)
            ->add('name', 'text', array('label' => 'Nom: ', 'required'=> false, 'label_attr' => array('class' => 'control-name'),  'attr' => array('class' => 'skipper-name')))
            ->add('email', 'text', array('label' => 'Email: ', 'required'=> false, 'label_attr' => array('class' => 'control-email'),  'attr' => array('class' => 'skipper-email')))
            ->add('photo1File', 'file', $optionsPhoto1)
            ->add('photo2File', 'file', $optionsPhoto2)
            ->add('photo3File', 'file', $optionsPhoto3)
            ->add('photo4File', 'file', $optionsPhoto4)
            ->add('photo5File', 'file', $optionsPhoto5)
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
                        'otherCertifications' => array(         
                            'label' => 'Autres certifications: ',
                            'locale_options' => array(
                                'en' => array(
                                    'label' => 'Other certifications: '
                                ),
                            'required' => false
                            )
                        ),              
                        'translatable_id' => array(   
                            'field_type' => 'hidden'
                        ),      
                        'hobbies' => array(         
                            'label' => 'Hobbies: ',
                            'locale_options' => array(
                                'en' => array(
                                    'label' => 'Hobbies: '
                                ),
                            'required' => false
                            )
                        )
                    )))
            ->add('yearsSailing', 'choice', array('label' => 'Années de navigation: ', 'required'=> false, 'label_attr' => array('class' => 'control-annee-navigation'),
                'choice_list' => $this->loadChoiceList()
            ))
            ->add('professionalSince', 'text', array('label' => 'Skipper professionnel depuis: ', 'required'=> false, 'attr' => array('class' => 'skipper-professional-since')))
            ->add('certificationDate', 'text', array('label' => 'Diplômes de voile: ', 'required'=> false, 'attr' => array('class' => 'skipper-date-certification')))
            ->add('yearsSailingCarribean', 'choice', array('label' => 'Années de navigation aux Antilles: ', 'required'=> false,  'label_attr' => array('class' => 'control-annee-navigation-caraibes'), 'attr' => array('class' => 'skipper-annee-navigation-caraibes'),
                'choice_list' => $this->loadChoiceList()
            ))
            ->add('yearsKiteSurfing', 'choice', array('label' => 'Pratique du Kitesurf depuis: ', 'required'=> false, 'label_attr' => array('class' => 'control-annee-kitesurfing'),
                'choice_list' => $this->loadYearsList("1997")
            ))
            ->add('yearsKiteCruise', 'choice', array('label' => 'Propose des croisières kite depuis: ', 'required'=> false,
                'choice_list' => $this->loadYearsList("2002")
            ))
            ->add('kitesurfInstructorSince', 'choice', array('label' => 'Instructeur de Kitesurf depuis: ', 'required'=> false,
                'choice_list' => $this->loadYearsList("2000")
            ))
            ->add('kitesurfCertification', 'text', array('label' => 'Diplôme de Kitesurf: ', 'required'=> false, 'attr' => array('class' => 'skipper-kitesurf-certification'), 'label_attr' => array('class' => 'control-kitesurf-certification')))
            ->add('languagesSpoken', 'choice', array('label' => 'Langues parlées: ', 'choice_list' => $this->loadLanguagesList(), 'multiple' => true, 'required' => false, 'label_attr' => array('class' => 'control-languages-spoken')))
            
            ->add('published', 'checkbox', array('label' => 'Publié: ', 'required'=> false))   
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
        ->add('name', null, array('label' => 'Nom: ', 'attr'=>array('class'=>'filter-control-name')));
    }
    
    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name', null, array('label' => 'Nom: ', 'sortable' => true))
            ->add('email')
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

    protected function loadYearsList($year) {
        $years = array(
            '1997' => '1997',
            '1998' => '1998',
            '1999' => '1999',
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
        
        $choices = new SimpleChoiceList(array_slice($years,array_search($year,array_keys($years))));
    
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
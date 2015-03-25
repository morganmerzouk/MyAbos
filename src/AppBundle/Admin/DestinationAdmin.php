<?php
// src/AppBundle/Admin/DestinationAdmin.php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;

class DestinationAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $optionsMiniature = array(
            'label' => 'Miniature: ',
            'required' => false,
            'label_attr' => array(
                'class' => 'control-miniature'
            ),
            'attr' => array(
                'class' => 'destination-miniature'
            )
        );
        
        $destination = $this->getSubject();
        
        if ($destination->getMiniatureWebPath()) {
            $optionsMiniature['help'] = '<img src="' . $destination->getMiniatureWebPath() . '" class="preview-img" />';
        }
        
        $formMapper->add('miniatureFile', 'file', $optionsMiniature)
            ->add('linkgmap', 'text', array(
            'label' => 'Lien google map: ',
            'required' => false,
            'label_attr' => array(
                'class' => 'control-lien-google-map'
            ),
            'attr' => array(
                'class' => 'destination-lien-google-map'
            )
        ))
            ->add('inclusRecherche', 'checkbox', array(
            'label' => 'Inclure dans la recherche: ',
            'attr' => array(
                'class' => 'destination-inclusrecherche'
            ),
            'required' => false
        ))
            ->add('translations', 'a2lix_translations', array(
            'attr' => array(
                'class' => 'test'
            ),
            'fields' => array(
                'name' => array(
                    'label' => 'Nom: ',
                    'locale_options' => array(
                        'en' => array(
                            'label' => 'Name: '
                        ),
                        'required' => false
                    )
                ),
                'description' => array(
                    'label' => 'Description: ',
                    'label_attr' => array(
                        'class' => 'control-description'
                    ),
                    'attr' => array(
                        'class' => 'tinymce',
                        'data-theme' => 'advanced'
                    ),
                    'locale_options' => array(
                        'en' => array(
                            'label' => 'Description: '
                        ),
                        'required' => false,
                        'class' => 'tinymce'
                    )
                ),
                'infosPratique' => array(
                    'label' => 'Infos Pratique: ',
                    'label_attr' => array(
                        'class' => 'control-infospratique'
                    ),
                    'attr' => array(
                        'class' => 'tinymce',
                        'data-theme' => 'advanced'
                    ),
                    'locale_options' => array(
                        'en' => array(
                            'label' => 'Infos pratique: '
                        ),
                        'required' => false,
                        'class' => 'tinymce'
                    )
                ),
                'translatable_id' => array(
                    'field_type' => 'hidden'
                )
            )
        ));
    }
    
    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('name', 'translatable_field', array(
            'field' => 'name',
            'personal_translation' => 'AppBundle\Entity\DestinationTranslation',
            'property_path' => 'translations',
            'label' => 'Nom: '
        ))->add('_action', 'actions', array(
            'actions' => array(
                'edit' => array(),
                'delete' => array()
            )
        ));
    }

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        
        return new ProxyQuery($query->leftjoin("AppBundle\Entity\DestinationTranslation", "dt", "WITH", "o.id=dt.translatable_id")->orderBy("dt.name", "ASC"));
    }

    public function setBaseRouteName($baseRouteName)
    {
        $this->baseRouteName = $baseRouteName;
    }

    public function setBaseRoutePattern($baseRoutePattern)
    {
        $this->baseRoutePattern = $baseRoutePattern;
    }

    public function prePersist($destination)
    {
        $this->saveFile($destination);
    }

    public function preUpdate($destination)
    {
        $this->saveFile($destination);
    }

    public function saveFile($destination)
    {
        $basepath = $this->getRequest()->getBasePath();
        $destination->upload($basepath);
    }
}
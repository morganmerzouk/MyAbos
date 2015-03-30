<?php
// src/AppBundle/Admin/ServicePayantAdmin.php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;

class ServicePayantAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $optionsIcone = array(
            'label' => 'Icone: ',
            'required' => false,
            'label_attr' => array(
                'class' => 'servicepayant-miniature'
            ),
            'attr' => array(
                'class' => 'optionpayante-miniature'
            )
        );
        
        $servicepayant = $this->getSubject();
        
        if ($servicepayant->getIconeWebPath()) {
            $optionsIcone['help'] = '<img src="' . $servicepayant->getIconeWebPath() . '" class="preview-img" />';
        }
        
        $formMapper->add('iconeFile', 'file', $optionsIcone)
            ->add('translations', 'a2lix_translations', array(
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
                        'class' => 'control-optionpayante_description'
                    ),
                    'attr' => array(
                        'class' => 'optionpayante_description'
                    ),
                    'locale_options' => array(
                        'en' => array(
                            'label' => 'Description: '
                        ),
                        'required' => false
                    )
                ),
                'translatable_id' => array(
                    'field_type' => 'hidden'
                )
            )
        ))
            ->add('categorie', 'choice', array(
            'label' => 'Catégorie d\'option payante: ',
            'label_attr' => array(
                'class' => 'control-optionpayante-categorie'
            ),
            'choice_list' => $this->loadChoiceList("categorie"),
            'attr' => array(
                "class" => "optionpayante-list-radio optionpayante-list-radio-categorie"
            ),
            'required' => true
        ))
            ->add('prestation', 'entity', array(
            'class' => 'AppBundle\Entity\Prestation',
            'label' => 'Rattachement à une prestation',
            'label_attr' => array(
                'class' => 'control-optionpayante-prestation'
            ),
            'required' => false,
            'empty_value' => "Aucune",
            'attr' => array(
                "class" => "optionpayante-list-radio"
            )
        ))
            ->add('bateau', 'entity', array(
            'class' => 'AppBundle\Entity\Bateau',
            'label' => 'Rattachement à un bateau spécifique',
            'label_attr' => array(
                'class' => 'control-optionpayante-bateau'
            ),
            'required' => true
        ))
            ->add('fraisSupplementaires', 'text', array(
            'label' => 'Frais supplémentaires: ',
            'label_attr' => array(
                'class' => 'control-optionpayante-frais'
            ),
            'attr' => array(
                'class' => 'optionpayante-frais'
            ),
            'required' => false
        ))
            ->add('devise', 'choice', array(
            'label' => 'Devise: ',
            'label_attr' => array(
                'class' => 'control-optionpayante-devise'
            ),
            'choice_list' => $this->loadChoiceList("devise"),
            'expanded' => true,
            'attr' => array(
                "class" => "optionpayante-list-radio optionpayante-list-radio-devise"
            ),
            'required' => false,
            'empty_value' => false
        ))
            ->add('tarifApplique', 'choice', array(
            'label' => '',
            'label_attr' => array(
                'class' => 'control-optionpayante-tarifapplique'
            ),
            'choice_list' => $this->loadChoiceList("tarifapplique"),
            'attr' => array(
                "class" => "optionpayante-list-radio"
            ),
            'required' => true
        ));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('prestation', null, array(
            'label' => 'Prestation: '
        ))->add('categorie', "doctrine_orm_choice", array(
            'label' => 'Catégorie: ',
            'class' => 'optionpayante-filter-categorie',
            'field_options' => array(
                'choices' => array(
                    'Equipiers supplémentaires' => 'Equipiers supplémentaires',
                    'Service d\'avitaillement supplémentaire' => 'Service d\'avitaillement supplémentaire',
                    'Autres prestations disponibles à bord' => 'Autres prestations disponibles à bord',
                    'Equipements supplémentaires' => 'Equipements supplémentaires',
                    'Activités supplémentaires' => 'Activités supplémentaires',
                    'Cours de kitesurf' => 'Cours de kitesurf'
                )
            ),
            'field_type' => 'choice'
        ));
    }
    
    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('name', 'translatable_field', array(
            'field' => 'name',
            'personal_translation' => 'AppBundle\Entity\ServicePayantTranslation',
            'property_path' => 'translations',
            'label' => 'Nom: ',
            'editable' => true
        ))
            ->add('categorie', 'translatable_field', array(
            'label' => 'Catégorie: '
        ))
            ->add('prestation.name', 'translatable_field', array(
            'field' => 'name',
            'personal_translation' => 'AppBundle\Entity\ServicePayantTranslation',
            'property_path' => 'translations',
            'label' => 'Prestation: '
        ))
            ->add('_action', 'actions', array(
            'actions' => array(
                'edit' => array(),
                'delete' => array()
            )
        ));
    }

    /**
     *
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        
        return new ProxyQuery($query->leftjoin("AppBundle\Entity\ServicePayantTranslation", "sp", "WITH", "o.id=sp.translatable_id AND sp.locale='en'")->orderBy("sp.name", "ASC"));
    }

    public function setBaseRouteName($baseRouteName)
    {
        $this->baseRouteName = $baseRouteName;
    }

    public function setBaseRoutePattern($baseRoutePattern)
    {
        $this->baseRoutePattern = $baseRoutePattern;
    }

    public function prePersist($inclusPrix)
    {
        $this->saveFile($inclusPrix);
    }

    public function preUpdate($inclusPrix)
    {
        $this->saveFile($inclusPrix);
    }

    public function saveFile($inclusPrix)
    {
        $basepath = $this->getRequest()->getBasePath();
        $inclusPrix->upload($basepath);
    }

    protected function loadChoiceList($type)
    {
        if ($type == "categorie") {
            $item = array(
                'Equipiers supplémentaires' => 'Equipiers supplémentaires',
                'Service d\'avitaillement supplémentaire' => 'Service d\'avitaillement supplémentaire',
                'Autres prestations disponibles à bord' => 'Autres prestations disponibles à bord',
                'Equipements supplémentaires' => 'Equipements supplémentaires',
                'Activités supplémentaires' => 'Activités supplémentaires',
                'Cours de kitesurf' => 'Cours de kitesurf'
            );
        } elseif ($type == "devise") {
            $item = array(
                "€" => "€",
                "$" => "$"
            );
        } elseif ($type == "tarifapplique") {
            $item = array(
                'Prix par personnejour' => 'Prix par personne/jour',
                'Prix par personnesemaine' => 'Prix par personne/semaine',
                'Prix du bateaujour' => 'Prix du bateau/jour',
                'Prix du bateau/semaine' => 'Prix du bateau/semaine'
            );
        }
        
        $choices = new SimpleChoiceList($item);
        
        return $choices;
    }
}
<?php
// src/AppBundle/Admin/OffreSpecialeAdmin.php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;

class OffreSpecialeAdmin extends Admin
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
                'class' => 'offrespeciale-miniature'
            )
        );
        
        $offreSpeciale = $this->getSubject();
        
        if ($offreSpeciale->getMiniatureWebPath()) {
            $optionsMiniature['help'] = '<img src="' . $offreSpeciale->getMiniatureWebPath() . '" class="preview-img" />';
        }
        $em = $this->modelManager->getEntityManager('AppBundle\Entity\InclusPrix');
        
        $queryServicePayant = $em->createQueryBuilder('sp')
            ->select('sp')
            ->from('AppBundle:ServicePayant', 'sp')
            ->leftJoin('AppBundle:ServicePayantTranslation', 'spt', 'WITH', 'sp.id=spt.translatable_id')
            ->orderBy('spt.name', 'ASC');
        
        $formMapper->add('translations', 'a2lix_translations', array(
            'fields' => array(
                'name' => array(
                    'label' => 'Titre de l\'offre: ',
                    'locale_options' => array(
                        'en' => array(
                            'label' => 'Offer name: '
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
                'translatable_id' => array(
                    'field_type' => 'hidden'
                )
            )
        ))
            ->add('miniatureFile', 'file', $optionsMiniature)
            ->add('portDepart', 'entity', array(
            'class' => 'AppBundle\Entity\PortDepart',
            'label' => "Port de départ: "
        ))
            ->add('destination', 'entity', array(
            'class' => 'AppBundle\Entity\Destination',
            'label' => "Destination: "
        ))
            ->add('bateau', 'entity', array(
            'class' => 'AppBundle\Entity\Bateau',
            'label' => "Bateau: "
        ))
            ->add('skipper', 'entity', array(
            'class' => 'AppBundle\Entity\Skipper',
            'label' => "Skipper: "
        ))
            ->add('nbCabine', 'choice', array(
            'label' => 'Nb de cabine: ',
            'label_attr' => array(
                'class' => 'control-offrespeciale-nbcabine'
            ),
            'choice_list' => $this->loadChoiceList("cabine"),
            'expanded' => true,
            'attr' => array(
                "class" => "offrespeciale-list-radio"
            )
        ))
            ->add('dateDebut', 'sonata_type_date_picker', array(
            'label' => 'Date début: ',
            'required' => true,
            'format' => 'dd/MM/yyyy'
        ))
            ->add('dateFin', 'sonata_type_date_picker', array(
            'label' => 'Date fin: ',
            'required' => true,
            'format' => 'dd/MM/yyyy'
        ))
            ->add('tarifPour', 'choice', array(
            'label' => 'Tarif pour: ',
            'label_attr' => array(
                'class' => 'control-tarifcroisiere-tarifpour'
            ),
            'attr' => array(
                'class' => 'tarifcroisiere-tarifpour'
            ),
            'choice_list' => $this->loadChoiceList("tarifPour")
        ))
            ->add('tarifDeuxPersonnes', 'integer', array(
            'label' => 'Tarif pour 2',
            'required' => false,
            'label_attr' => array(
                'class' => 'control-tarifcroisiere-tarifdeuxpersonne'
            ),
            'attr' => array(
                'class' => 'tarifcroisiere-tarifdeuxpersonne'
            )
        ))
            ->add('tarifTroisPersonnes', 'integer', array(
            'label' => 'Tarif pour 3',
            'required' => false,
            'label_attr' => array(
                'class' => 'control-tarifcroisiere-tariftroispersonne'
            ),
            'attr' => array(
                'class' => 'tarifcroisiere-tariftroispersonne'
            )
        ))
            ->add('tarifQuatrePersonnes', 'integer', array(
            'label' => 'Tarif pour 4',
            'required' => false,
            'label_attr' => array(
                'class' => 'control-tarifcroisiere-tarifquatrepersonne'
            ),
            'attr' => array(
                'class' => 'tarifcroisiere-tarifquatrepersonne'
            )
        ))
            ->add('tarifCinqPersonnes', 'integer', array(
            'label' => 'Tarif pour 5',
            'required' => false,
            'label_attr' => array(
                'class' => 'control-tarifcroisiere-tarifcinqpersonne'
            ),
            'attr' => array(
                'class' => 'tarifcroisiere-tarifcinqpersonne'
            )
        ))
            ->add('tarifSixPersonnes', 'integer', array(
            'label' => 'Tarif pour 6',
            'required' => false,
            'label_attr' => array(
                'class' => 'control-tarifcroisiere-tarifsixpersonne'
            ),
            'attr' => array(
                'class' => 'tarifcroisiere-tarifsixpersonne'
            )
        ))
            ->add('tarifSeptPersonnes', 'integer', array(
            'label' => 'Tarif pour 7',
            'required' => false,
            'label_attr' => array(
                'class' => 'control-tarifcroisiere-tarifseptpersonne'
            ),
            'attr' => array(
                'class' => 'tarifcroisiere-tarifseptpersonne'
            )
        ))
            ->add('tarifHuitPersonnes', 'integer', array(
            'label' => 'Tarif pour 8',
            'required' => false,
            'label_attr' => array(
                'class' => 'control-tarifcroisiere-tarifhuitpersonne'
            ),
            'attr' => array(
                'class' => 'tarifcroisiere-tarifhuitpersonne'
            )
        ))
            ->add('servicePayant', 'sonata_type_model', array(
            'query' => $queryServicePayant,
            'label_attr' => array(
                'class' => 'control-croisiere-servicepayant'
            ),
            'attr' => array(
                "class" => "croisiere-servicepayant"
            ),
            'required' => false,
            'multiple' => true,
            'empty_value' => 'Service',
            'label' => 'Services Payants: ',
            'btn_add' => false
        ));
    }
    
    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('name', 'translatable_field', array(
            'field' => 'name',
            'personal_translation' => 'AppBundle\Entity\OffreSpecialeTranslation',
            'property_path' => 'translations',
            'label' => 'Nom: '
        ))->add('_action', 'actions', array(
            'actions' => array(
                'edit' => array(),
                'delete' => array(),
                'Clone' => array(
                    'template' => 'AppBundle:Admin/CRUD:list__action_clone.html.twig'
                )
            )
        ));
    }

    protected function loadChoiceList($type)
    {
        if ($type == "tarifPour") {
            $item = array(
                '1 jour/bateau' => '1 jour/bateau',
                '1 jour/personne' => '1 jour/personne',
                '7 jours/bateau' => '7 jours/bateau',
                '7 jours/personne' => '7 jours/personne',
                '10 jours/bateau' => '10 jours/bateau',
                '10 jours/personne' => '10 jours/personne'
            );
        } elseif ($type == "cabine") {
            $item = array(
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6'
            );
        }
        
        $choices = new SimpleChoiceList($item);
        
        return $choices;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('clone', $this->getRouterIdParameter() . '/clone');
        $collection->add('getServicePayant', 'getServicePayant/{id}', array(
            'id' => null
        ));
        $collection->add('offresspeciales', $this->getRouterIdParameter() . '/offresspeciales');
    }

    public function setBaseRouteName($baseRouteName)
    {
        $this->baseRouteName = $baseRouteName;
    }

    public function setBaseRoutePattern($baseRoutePattern)
    {
        $this->baseRoutePattern = $baseRoutePattern;
    }

    public function prePersist($offreSpeciale)
    {
        $this->saveFile($offreSpeciale);
    }

    public function preUpdate($offreSpeciale)
    {
        $this->saveFile($offreSpeciale);
    }

    public function saveFile($offreSpeciale)
    {
        $basepath = $this->getRequest()->getBasePath();
        $offreSpeciale->upload($basepath);
    }
}
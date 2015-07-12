<?php
// src/AppBundle/Admin/TarifCroisiereAdmin.php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;

class TarifCroisiereAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $croisiere = $this->getRoot()->getSubject();
        $ic = $croisiere->getItineraireCroisiere();
        $ids = array();
        foreach ($ic as $itineraireCroisiere) {
            array_push($ids, $itineraireCroisiere->getId());
        }
        
        $em = $this->modelManager->getEntityManager('AppBundle\Entity\ItineraireCroisiere');
        $query = $em->createQueryBuilder('ic')
            ->select('ic')
            ->from('AppBundle:ItineraireCroisiere', 'ic')
            ->where('ic.id IN (:ids)')
            ->setParameter(':ids', $ids);
        $formMapper->add('itineraireCroisiere', 'sonata_type_model', array(
            'required' => false,
            'query' => $query
        ))
            ->add('translations', 'a2lix_translations', array(
            'fields' => array(
                'name' => array(
                    'label' => 'Nom: ',
                    'label_attr' => array(
                        'class' => 'control-tarifcroisiere-name'
                    ),
                    'attr' => array(
                        'class' => 'tarifcroisiere-name',
                        'data-theme' => 'advanced'
                    ),
                    'sonata_field_description' => 'textarea',
                    'locale_options' => array(
                        'en' => array(
                            'label' => 'Name: '
                        ),
                        'required' => false
                    )
                ),
                'translatable_id' => array(
                    'field_type' => 'hidden'
                )
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
            ->add('nombreJourMinimum', 'choice', array(
            'label' => 'Nb jour minimum: ',
            'label_attr' => array(
                'class' => 'control-tarifcroisiere-nombrejourminimum'
            ),
            'attr' => array(
                'class' => 'tarifcroisiere-nombrejourminimum'
            ),
            'choice_list' => $this->loadChoiceList("nombreJourMinimum")
        ))
            ->add('nombreJourMaximum', 'choice', array(
            'label' => 'Nb jour maximum: ',
            'label_attr' => array(
                'class' => 'control-tarifcroisiere-nombrejourmaximum'
            ),
            'attr' => array(
                'class' => 'tarifcroisiere-nombrejourmaximum'
            ),
            'choice_list' => $this->loadChoiceList("nombreJourMaximum")
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
            ->add('tarifUnePersonne', 'integer', array(
            'label' => 'Tarif pour 1',
            'required' => false,
            'label_attr' => array(
                'class' => 'control-tarifcroisiere-tarifunepersonne'
            ),
            'attr' => array(
                'class' => 'tarifcroisiere-tarifunepersonne'
            )
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
        ));
    }
    
    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('dateDebut', 'date', array(
            'label' => 'Date début: '
        ))
            ->add('dateFin', 'date', array(
            'label' => 'Date fin: '
        ))
            ->add('_action', 'actions', array(
            'actions' => array(
                'edit' => array(),
                'delete' => array()
            )
        ));
    }

    protected function loadChoiceList($type, $ic = null)
    {
        if ($type == "nombreJourMinimum") {
            $item = array(
                '1' => '1 jour',
                '2' => '2 jours',
                '3' => '3 jours',
                '4' => '4 jours',
                '5' => '5 jours',
                '6' => '6 jours',
                '7' => '7 jours',
                '8' => '8 jours',
                '9' => '9 jours',
                '10' => '10 jours'
            );
        } elseif ($type == "nombreJourMaximum") {
            $item = array(
                '' => '',
                '3' => '3 jours',
                '4' => '4 jours',
                '5' => '5 jours',
                '6' => '6 jours',
                '7' => '7 jours',
                '8' => '8 jours',
                '9' => '9 jours',
                '10' => '10 jours',
                '11' => '11 jours',
                '12' => '12 jours',
                '13' => '13 jours',
                '14' => '14 jours',
                '15' => '15 jours',
                '16' => '16 jours',
                '17' => '17 jours',
                '18' => '18 jours',
                '19' => '19 jours',
                '20' => '20 jours',
                '21' => '21 jours'
            );
        } elseif ($type == "tarifPour") {
            $item = array(
                'bateau' => 'bateau',
                'jour' => 'jour',
                '1 jour/bateau' => '1 jour/bateau',
                '1 jour/personne' => '1 jour/personne',
                '7 jours/bateau' => '7 jours/bateau',
                '7 jours/personne' => '7 jours/personne',
                '10 jours/bateau' => '10 jours/bateau',
                '10 jours/personne' => '10 jours/personne'
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
}
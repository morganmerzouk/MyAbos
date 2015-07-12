<?php
// src/AppBundle/Admin/BateauAdmin.php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

class BateauAdmin extends Admin
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
                'class' => 'bateau-miniature'
            )
        );
        $optionsPhotoVoile = array(
            'label' => 'Voile: ',
            'required' => false,
            'label_attr' => array(
                'class' => 'control-photo control-photo1'
            ),
            'attr' => array(
                'class' => 'bateau-photo'
            )
        );
        $optionsPhotoMouillage = array(
            'label' => 'Mouillage: ',
            'required' => false,
            'label_attr' => array(
                'class' => 'control-photo'
            ),
            'attr' => array(
                'class' => 'bateau-photo'
            )
        );
        $optionsPhotoCockpit = array(
            'label' => 'Cockpit: ',
            'required' => false,
            'label_attr' => array(
                'class' => 'control-photo'
            ),
            'attr' => array(
                'class' => 'bateau-photo'
            )
        );
        $optionsPhotoCarre = array(
            'label' => 'Carre: ',
            'required' => false,
            'label_attr' => array(
                'class' => 'control-photo'
            ),
            'attr' => array(
                'class' => 'bateau-photo'
            )
        );
        $optionsPhotoCabine = array(
            'label' => 'Cabine: ',
            'required' => false,
            'label_attr' => array(
                'class' => 'control-photo'
            ),
            'attr' => array(
                'class' => 'bateau-photo'
            )
        );
        
        $bateau = $this->getSubject();
        
        if ($bateau->getMiniatureWebPath()) {
            $optionsMiniature['help'] = '<img src="' . $bateau->getMiniatureWebPath() . '" class="preview-img" />';
        }
        if ($bateau->getPhotoVoileWebPath()) {
            $optionsPhotoVoile['help'] = '<img src="' . $bateau->getPhotoVoileWebPath() . '" class="preview-img" />';
        }
        if ($bateau->getPhotoMouillageWebPath()) {
            $optionsPhotoMouillage['help'] = '<img src="' . $bateau->getPhotoMouillageWebPath() . '" class="preview-img" />';
        }
        if ($bateau->getPhotoCockpitWebPath()) {
            $optionsPhotoCockpit['help'] = '<img src="' . $bateau->getPhotoCockpitWebPath() . '" class="preview-img" />';
        }
        if ($bateau->getPhotoCarreWebPath()) {
            $optionsPhotoCarre['help'] = '<img src="' . $bateau->getPhotoCarreWebPath() . '" class="preview-img"/>';
        }
        if ($bateau->getPhotoCabineWebPath()) {
            $optionsPhotoCabine['help'] = '<img src="' . $bateau->getPhotoCabineWebPath() . '" class="preview-img"/>';
        }
        
        $em = $this->modelManager->getEntityManager('AppBundle\Entity\InclusPrix');
        
        $queryEquipage = $em->createQueryBuilder('ip')
            ->select('ip')
            ->from('AppBundle:InclusPrix', 'ip')
            ->leftJoin('AppBundle:InclusPrixTranslation', 'ipt', 'WITH', 'ip.id=ipt.translatable_id')
            ->where('ip.categorie=:categorie')
            ->setParameter(":categorie", "Equipage")
            ->orderBy('ipt.name', 'ASC');
        
        $queryFraisVoyage = $em->createQueryBuilder('ip')
            ->select('ip')
            ->from('AppBundle:InclusPrix', 'ip')
            ->leftJoin('AppBundle:InclusPrixTranslation', 'ipt', 'WITH', 'ip.id=ipt.translatable_id')
            ->where('ip.categorie=:categorie')
            ->setParameter(":categorie", "Frais de voyage")
            ->orderBy('ipt.name', 'ASC');
        
        $queryAvitaillement = $em->createQueryBuilder('ip')
            ->select('ip')
            ->from('AppBundle:InclusPrix', 'ip')
            ->leftJoin('AppBundle:InclusPrixTranslation', 'ipt', 'WITH', 'ip.id=ipt.translatable_id')
            ->where('ip.categorie=:categorie')
            ->setParameter(":categorie", "Avitaillement")
            ->orderBy('ipt.name', 'ASC');
        
        $queryAutresServices = $em->createQueryBuilder('ip')
            ->select('ip')
            ->from('AppBundle:InclusPrix', 'ip')
            ->leftJoin('AppBundle:InclusPrixTranslation', 'ipt', 'WITH', 'ip.id=ipt.translatable_id')
            ->where('ip.categorie=:categorie')
            ->setParameter(":categorie", "Autres services")
            ->orderBy('ipt.name', 'ASC');
        
        $queryEquipement = $em->createQueryBuilder('ip')
            ->select('ip')
            ->from('AppBundle:InclusPrix', 'ip')
            ->leftJoin('AppBundle:InclusPrixTranslation', 'ipt', 'WITH', 'ip.id=ipt.translatable_id')
            ->where('ip.categorie=:categorie')
            ->setParameter(":categorie", "Equipements à bord")
            ->orderBy('ipt.name', 'ASC');
        
        $queryActivite = $em->createQueryBuilder('ip')
            ->select('ip')
            ->from('AppBundle:InclusPrix', 'ip')
            ->leftJoin('AppBundle:InclusPrixTranslation', 'ipt', 'WITH', 'ip.id=ipt.translatable_id')
            ->where('ip.categorie=:categorie')
            ->setParameter(":categorie", "Activités à bord")
            ->orderBy('ipt.name', 'ASC');
        
        $queryCours = $em->createQueryBuilder('ip')
            ->select('ip')
            ->from('AppBundle:InclusPrix', 'ip')
            ->leftJoin('AppBundle:InclusPrixTranslation', 'ipt', 'WITH', 'ip.id=ipt.translatable_id')
            ->where('ip.categorie=:categorie')
            ->setParameter(":categorie", "Cours de kitesurf")
            ->orderBy('ipt.name', 'ASC');
        $formMapper->add('miniatureFile', 'file', $optionsMiniature)
            ->add('name', 'text', array(
            'label' => 'Nom: ',
            'required' => false,
            'label_attr' => array(
                'class' => 'control-name'
            ),
            'attr' => array(
                'class' => 'skipper-name'
            )
        ))
            ->add('photoVoileFile', 'file', $optionsPhotoVoile)
            ->add('photoMouillageFile', 'file', $optionsPhotoMouillage)
            ->add('photoCockpitFile', 'file', $optionsPhotoCockpit)
            ->add('photoCarreFile', 'file', $optionsPhotoCarre)
            ->add('photoCabineFile', 'file', $optionsPhotoCabine)
            ->add('type', 'choice', array(
            'label' => 'Type: ',
            'expanded' => true,
            'label_attr' => array(
                'class' => 'control-bateau-type'
            ),
            'choice_list' => $this->loadChoiceList("type"),
            'attr' => array(
                "class" => "bateau-list-radio"
            )
        ))
            ->add('nbCabine', 'choice', array(
            'label' => 'Nb de cabine: ',
            'label_attr' => array(
                'class' => 'control-bateau-nbcabine'
            ),
            'choice_list' => $this->loadChoiceList("cabine"),
            'expanded' => true,
            'attr' => array(
                "class" => "bateau-list-radio"
            )
        ))
            ->add('nbDouche', 'choice', array(
            'label' => 'Nb de douche: ',
            'label_attr' => array(
                'class' => 'control-bateau-nbdouche'
            ),
            'choice_list' => $this->loadChoiceList("douche"),
            'expanded' => true,
            'attr' => array(
                "class" => "bateau-list-radio"
            )
        ))
            ->add('nbCouchage', 'choice', array(
            'label' => 'Nb de Couchage: ',
            'label_attr' => array(
                'class' => 'control-bateau-nbcouchage'
            ),
            'choice_list' => $this->loadChoiceList("couchage"),
            'expanded' => true,
            'attr' => array(
                "class" => "bateau-list-radio"
            )
        ))
            ->add('nbLitSimple', 'choice', array(
            'label' => 'Nb de lit simple: ',
            'label_attr' => array(
                'class' => 'control-bateau-nblitsimple'
            ),
            'choice_list' => $this->loadChoiceList("litsimple"),
            'expanded' => true,
            'attr' => array(
                "class" => "bateau-list-radio"
            )
        ))
            ->add('nbLitDouble', 'choice', array(
            'label' => 'Nb de lit double: ',
            'label_attr' => array(
                'class' => 'control-bateau-nblitdouble'
            ),
            'choice_list' => $this->loadChoiceList("litdouble"),
            'expanded' => true,
            'attr' => array(
                "class" => "bateau-list-radio"
            )
        ))
            ->add('translations', 'a2lix_translations', array(
            'fields' => array(
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
                ),
                'longueur' => array(
                    'label' => 'Longueur: ',
                    'label_attr' => array(
                        'class' => 'control-longueur'
                    ),
                    'attr' => array(
                        'class' => 'bateau-longueur'
                    ),
                    'locale_options' => array(
                        'en' => array(
                            'label' => 'Length: '
                        ),
                        'required' => false
                    )
                ),
                'largeur' => array(
                    'label' => 'Largeur: ',
                    'label_attr' => array(
                        'class' => 'control-largeur'
                    ),
                    'attr' => array(
                        'class' => 'bateau-largeur'
                    ),
                    'locale_options' => array(
                        'en' => array(
                            'label' => 'Width: '
                        ),
                        'required' => false
                    )
                ),
                'tirantdeau' => array(
                    'label' => 'Tirant d\'eau: ',
                    'label_attr' => array(
                        'class' => 'control-tirantdeau'
                    ),
                    'attr' => array(
                        'class' => 'bateau-tirantdeau'
                    ),
                    'locale_options' => array(
                        'en' => array(
                            'label' => 'Tirant d\'eau: '
                        ),
                        'required' => false
                    )
                ),
                'moteur' => array(
                    'label' => 'Moteur: ',
                    'label_attr' => array(
                        'class' => 'control-moteur'
                    ),
                    'attr' => array(
                        'class' => 'bateau-moteur'
                    ),
                    'locale_options' => array(
                        'en' => array(
                            'label' => 'Engine: '
                        ),
                        'required' => false
                    )
                ),
                'surfaceGrandVoile' => array(
                    'label' => 'Surface grand voile: ',
                    'label_attr' => array(
                        'class' => 'control-surfacegrandvoile'
                    ),
                    'attr' => array(
                        'class' => 'bateau-surfacegrandvoile'
                    ),
                    'locale_options' => array(
                        'en' => array(
                            'label' => 'Main sail: '
                        ),
                        'required' => false
                    )
                ),
                'reservoirCarburant' => array(
                    'label' => 'Réservoir carburant: ',
                    'label_attr' => array(
                        'class' => 'control-reservoirCarburant'
                    ),
                    'attr' => array(
                        'class' => 'bateau-reservoirCarburant'
                    ),
                    'locale_options' => array(
                        'en' => array(
                            'label' => 'Fuel tank: '
                        ),
                        'required' => false
                    )
                ),
                'reservoirEau' => array(
                    'label' => 'Réservoir d\'eau: ',
                    'label_attr' => array(
                        'class' => 'control-reservoirEau'
                    ),
                    'attr' => array(
                        'class' => 'bateau-reservoirEau'
                    ),
                    'locale_options' => array(
                        'en' => array(
                            'label' => 'Water tank: '
                        ),
                        'required' => false
                    )
                ),
                'energie' => array(
                    'label' => 'Energie: ',
                    'label_attr' => array(
                        'class' => 'control-bateau-energie'
                    ),
                    'attr' => array(
                        'class' => 'bateau-energie'
                    ),
                    'locale_options' => array(
                        'en' => array(
                            'label' => 'Energy supplies: '
                        ),
                        'required' => false
                    )
                ),
                'equipementCuisine' => array(
                    'label' => 'Equipement en cuisine: ',
                    'label_attr' => array(
                        'class' => 'control-bateau-equipement'
                    ),
                    'attr' => array(
                        'class' => 'bateau-equipement'
                    ),
                    'locale_options' => array(
                        'en' => array(
                            'label' => 'Galley Equipments: '
                        ),
                        'required' => false
                    )
                ),
                'dinghy' => array(
                    'label' => 'Annexe: ',
                    'label_attr' => array(
                        'class' => 'control-bateau-canot'
                    ),
                    'attr' => array(
                        'class' => 'bateau-canot'
                    ),
                    'locale_options' => array(
                        'en' => array(
                            'label' => 'Dinghy: '
                        ),
                        'required' => false
                    )
                ),
                'loisir' => array(
                    'label' => 'Loisirs: ',
                    'label_attr' => array(
                        'class' => 'control-bateau-loisir'
                    ),
                    'attr' => array(
                        'class' => 'bateau-loisir'
                    ),
                    'locale_options' => array(
                        'en' => array(
                            'label' => 'Entertainment: '
                        ),
                        'required' => false
                    )
                ),
                'jouet' => array(
                    'label' => 'Jouet: ',
                    'label_attr' => array(
                        'class' => 'control-bateau-jouet'
                    ),
                    'attr' => array(
                        'class' => 'bateau-jouet'
                    ),
                    'locale_options' => array(
                        'en' => array(
                            'label' => 'Toys aboard: '
                        ),
                        'required' => false
                    )
                ),
                'autre' => array(
                    'label' => 'Autres informations: ',
                    'label_attr' => array(
                        'class' => 'control-bateau-autre'
                    ),
                    'attr' => array(
                        'class' => 'bateau-autre'
                    ),
                    'locale_options' => array(
                        'en' => array(
                            'label' => 'Additional infos: '
                        ),
                        'required' => false
                    )
                )
            )
        ))
            ->add('inclusPrixEquipage', 'sonata_type_model', array(
            'query' => $queryEquipage,
            'label_attr' => array(
                'class' => 'control-bateau-inclusequipage'
            ),
            'attr' => array(
                "class" => "bateau-inclusequipage"
            ),
            'required' => false,
            'empty_value' => 'Inclus Prix Equipage',
            'label' => '',
            'btn_add' => false
        ))
            ->add('inclusPrixFraisVoyage', 'sonata_type_model', array(
            'query' => $queryFraisVoyage,
            'required' => false,
            'multiple' => true,
            'expanded' => true,
            'attr' => array(
                'class' => 'bateau-inclusprix-frais'
            ),
            'label_attr' => array(
                'class' => 'control-bateau-fraisvoyage'
            ),
            'label' => 'Frais du bateau: ',
            'btn_add' => false
        ))
            ->add('inclusPrixAvitaillement', 'sonata_type_model', array(
            'query' => $queryAvitaillement,
            'required' => false,
            'multiple' => true,
            'label' => 'Avitaillement: ',
            'empty_value' => 'Avitaillement',
            'btn_add' => false
        ))
            ->add('inclusPrixAutresServices', 'sonata_type_model', array(
            'query' => $queryAutresServices,
            'required' => false,
            'multiple' => true,
            'label' => 'Autres services: ',
            'empty_value' => 'Autres services',
            'btn_add' => false
        ))
            ->add('inclusPrixEquipement', 'sonata_type_model', array(
            'query' => $queryEquipement,
            'required' => false,
            'multiple' => true,
            'label' => 'Equipements à bord: ',
            'empty_value' => 'Equipements à bord',
            'btn_add' => false
        ))
            ->add('inclusPrixActivite', 'sonata_type_model', array(
            'query' => $queryActivite,
            'required' => false,
            'multiple' => true,
            'label' => 'Activités à bord: ',
            'empty_value' => 'Activités à bord',
            'btn_add' => false
        ))
            ->add('inclusPrixCours', 'sonata_type_model', array(
            'query' => $queryCours,
            'required' => false,
            'multiple' => true,
            'label' => 'Cours de kitesurf: ',
            'empty_value' => 'Cours de kitesurf',
            'btn_add' => false
        ))
            ->add('actif', 'checkbox', array(
            'label' => 'Public?',
            'required' => false
        ));
    }
    
    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('name', null, array(
            'label' => 'Nom: '
        ))->add('_action', 'actions', array(
            'actions' => array(
                'edit' => array(),
                'delete' => array()
            )
        ));
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('name', null, array(
            'label' => 'Nom: ',
            'attr' => array(
                'class' => 'filter-control-name'
            )
        ));
    }

    public function getInclusPrixEquipage($queryBuilder, $alias, $field, $value)
    {
        if (! $value) {
            return;
        }
        
        $queryBuilder->leftJoin(sprintf('%s.inclusprix', $alias), 'c');
        $queryBuilder->andWhere('c.categorie = :categorie');
        $queryBuilder->setParameter('categorie', "Equipage");
        
        return true;
    }

    protected $datagridValues = array(
        '_page' => 1,
        '_sort_order' => 'ASC',
        '_sort_by' => 'name'
    );

    protected function loadChoiceList($type)
    {
        if ($type == "cabine") {
            $item = array(
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6'
            );
        } elseif ($type == "couchage") {
            $item = array(
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6',
                '7' => '7',
                '8' => '8',
                '9' => '9',
                '10' => '10'
            );
        } elseif ($type == "litsimple") {
            $item = array(
                '0' => '0',
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6'
            );
        } elseif ($type == "litdouble") {
            $item = array(
                '0' => '0',
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4'
            );
        } elseif ($type == "type") {
            $item = array(
                'Monohull' => 'Monohull',
                'Catamaran' => 'Catamaran'
            );
        } elseif ($type == "douche") {
            $item = array(
                '0' => '0',
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4'
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

    public function prePersist($bateau)
    {
        $this->saveFile($bateau);
    }

    public function preUpdate($bateau)
    {
        $this->saveFile($bateau);
    }

    public function saveFile($bateau)
    {
        $basepath = $this->getRequest()->getBasePath();
        $bateau->upload($bateau);
    }
}
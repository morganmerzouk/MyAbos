<?php
// src/AppBundle/Admin/ItineraireAdmin.php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Doctrine\ORM\EntityRepository;

class ItineraireAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $optionsMiniature = array(
            'label' => 'Image itinéraire: ',
            'required' => false,
            'attr' => array(
                'class' => 'itineraire-miniature'
            )
        );
        
        $portDepart = $this->getSubject();
        
        if ($portDepart->getMiniatureWebPath()) {
            $optionsMiniature['help'] = '<img src="' . $portDepart->getMiniatureWebPath() . '" class="preview-img" />';
        }
        
        $formMapper->add('miniatureFile', 'file', $optionsMiniature)
            ->add('portDepart', 'entity', array(
            'class' => 'AppBundle:PortDepart',
            'property' => 'name',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('pd')
                    ->select('pd,pdt')
                    ->join("pd.translations", "pdt")
                    ->where("pdt.locale='en'")
                    ->orderBy('pdt.name', 'ASC');
            },
            'label' => "Port de départ: ",
            'required' => true
        ))
            ->add('destination', 'entity', array(
            'class' => 'AppBundle:Destination',
            'property' => 'name',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('d')
                    ->select('d,dt')
                    ->join("d.translations", "dt")
                    ->where("dt.locale='en'")
                    ->orderBy('dt.name', 'ASC');
            },
            'label' => "Destination: ",
            'required' => true
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
                    'sonata_field_description' => 'textarea',
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
        ));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('portDepart', null, array(
            'label' => 'Port de départ: '
        ))->add('destination', null, array(
            'label' => 'Destination: '
        ));
    }
    
    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('portDepart.name', 'translatable_field', array(
            'personal_translation' => 'AppBundle\Entity\ItineraireTranslation',
            'property_path' => 'translations',
            'label' => 'Port de départ: '
        ))
            ->add('destination.name', 'translatable_field', array(
            'field' => 'name',
            'personal_translation' => 'AppBundle\Entity\ItineraireTranslation',
            'property_path' => 'translations',
            'label' => 'Destination: '
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
        
        return new ProxyQuery($query->join(sprintf('%s.portDepart', $query->getRootAlias()), 'c')
            ->join('AppBundle\Entity\PortDepartTranslation', 'pt', 'WITH', 'c.id = pt.translatable_id AND pt.locale=:locale')
            ->setParameter(':locale', "en")
            ->orderBy('pt.name'));
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

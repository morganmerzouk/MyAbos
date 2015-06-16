<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;

class BateauDevisType extends AbstractType
{

    private $em;

    private $locale;

    private $id;

    public function __construct(EntityManager $em, $locale, $id = null)
    {
        $this->em = $em;
        $this->locale = $locale;
        $this->id = $id;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $formatPattern = $this->locale == "en" ? 'MM/dd/yyyy' : 'dd/MM/yyyy';
        $builder->add('dateDepart', 'date', array(
            'label' => "form_sejour_departure_on",
            'required' => false,
            'widget' => 'single_text',
            'attr' => array(
                'class' => 'input-date-depart-devis'
            ),
            'format' => $formatPattern
        ))
            ->add('dateRetour', 'date', array(
            'label' => "form_sejour_back_on",
            'label_attr' => array(
                'class' => 'label-date-retour'
            ),
            'required' => false,
            'widget' => 'single_text',
            'attr' => array(
                'class' => 'input-date-retour-devis'
            ),
            'format' => $formatPattern
        ))
            ->add('nbPassager', 'choice', array(
            'label' => 'form_sejour_nb_passager',
            'required' => false,
            'label_attr' => array(
                'class' => 'label-nb-passager'
            ),
            'choice_list' => $this->loadChoiceList("nbPassager"),
            'attr' => array(
                "class" => "select-nb-passager-devis"
            )
        ))
            ->add('itineraire', 'choice', array(
            "choices" => $this->fillItineraire(),
            'required' => false,
            'label' => 'form_sejour_itineraire',
            'attr' => array(
                'class' => 'select-itineraire-devis'
            ),
            'empty_value' => "whatever"
        ))
            ->add('message', 'textarea', array(
            'label' => '',
            'required' => false,
            'label_attr' => array(
                'class' => 'label-textarea-message'
            ),
            'attr' => array(
                'class' => 'textarea-message',
                'placeholder' => 'form_sejour_message'
            )
        ))
            ->add('nom', 'text', array(
            'label' => '',
            'required' => false,
            'label_attr' => array(
                'class' => 'label-nom'
            ),
            'attr' => array(
                'class' => 'input-nom',
                'placeholder' => 'form_sejour_nom'
            )
        ))
            ->add('email', 'email', array(
            'label' => '',
            'required' => false,
            'label_attr' => array(
                'class' => 'label-email'
            ),
            'attr' => array(
                'class' => 'input-email',
                'placeholder' => 'form_sejour_email'
            )
        ))
            ->add('prix', 'hidden', array(
            'attr' => array(
                'class' => 'field_prix'
            )
        ));
    }

    protected function loadChoiceList($type)
    {
        if ($type == "nbPassager") {
            $results = $this->em->getRepository("AppBundle\Entity\Croisiere")
                ->createQueryBuilder('c')
                ->select('c,tc')
                ->join('c.tarifCroisiere', 'tc')
                ->where('c.bateau = :id')
                ->setParameter(":id", $this->id)
                ->getQuery()
                ->getResult();
            
            $listeNbPassager = array(
                '' => '-'
            );
            if (count($results) > 0) {
                foreach ($results[0]->getTarifCroisiere() as $result) {
                    if ($result->getTarifDeuxPersonnes() != null) {
                        $listeNbPassager['2'] = '2';
                    }
                    if ($result->getTarifTroisPersonnes() != null) {
                        $listeNbPassager['3'] = '3';
                    }
                    if ($result->getTarifQuatrePersonnes() != null) {
                        $listeNbPassager['4'] = '4';
                    }
                    if ($result->getTarifCinqPersonnes() != null) {
                        $listeNbPassager['5'] = '5';
                    }
                    if ($result->getTarifSixPersonnes() != null) {
                        $listeNbPassager['6'] = '6';
                    }
                    if ($result->getTarifSeptPersonnes() != null) {
                        $listeNbPassager['7'] = '7';
                    }
                    if ($result->getTarifHuitPersonnes() != null) {
                        $listeNbPassager['8'] = '8';
                    }
                }
            }
            
            $item = $listeNbPassager;
        }
        $choices = new SimpleChoiceList($item);
        
        return $choices;
    }

    private function fillDestination()
    {
        $results = $this->em->getRepository("AppBundle\Entity\Croisiere")
            ->createQueryBuilder('c')
            ->select('t.translatable_id as id, t.name')
            ->join('c.itineraireCroisiere', 'ic')
            ->join('ic.itineraire', 'i')
            ->join('i.destination', 'd')
            ->join('d.translations', 't')
            ->where("t.locale = :locale")
            ->andWhere('c.bateau = :id')
            ->setParameter(":locale", $this->locale)
            ->setParameter(":id", $this->id)
            ->orderBy('t.name', 'ASC')
            ->getQuery()
            ->getResult();
        
        $destination = array();
        foreach ($results as $dest) {
            $destination[$dest['name']] = $dest['name'];
        }
        
        return $destination;
    }

    private function fillItineraire()
    {
        $results = $this->em->getRepository("AppBundle\Entity\Croisiere")
            ->createQueryBuilder('c')
            ->join('c.itineraireCroisiere', 'ic')
            ->join('ic.itineraire', 'i')
            ->join('i.translations', 't')
            ->where("t.locale = :locale")
            ->andWhere('c.bateau = :id')
            ->setParameter(":locale", $this->locale)
            ->setParameter(":id", $this->id)
            ->orderBy('t.name', 'ASC')
            ->getQuery()
            ->getResult();
        
        $itineraires = array();
        foreach ($results as $croisiere) {
            foreach ($croisiere->getItineraireCroisiere() as $itineraireCroisiere) {
                $itineraires[$itineraireCroisiere->getItineraire()->getName()] = $itineraireCroisiere->getItineraire()->getName();
            }
        }
        
        return $itineraires;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'intention' => 'bateaudevis_item'
        ));
    }

    public function getName()
    {
        return "bateaudevis";
    }
}
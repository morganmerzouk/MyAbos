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
            'label' => "form_sejour_possible_debut",
            'required' => false,
            'widget' => 'single_text',
            'attr' => array(
                'class' => 'input-date-depart'
            ),
            'format' => $formatPattern
        ))
            ->add('dateRetour', 'date', array(
            'label' => "form_sejour_possible_fin",
            'label_attr' => array(
                'class' => 'label-date-retour'
            ),
            'required' => false,
            'widget' => 'single_text',
            'attr' => array(
                'class' => 'input-date-retour'
            ),
            'format' => $formatPattern
        ))
            ->add('dureeCroisiere', 'choice', array(
            'label' => 'form_sejour_duree',
            'label_attr' => array(
                'class' => 'label-duree-sejour'
            ),
            'choice_list' => $this->loadChoiceList("dureeCroisiere"),
            'attr' => array(
                "class" => "select-duree-sejour"
            )
        ))
            ->add('nbPassager', 'choice', array(
            'label' => 'form_sejour_nb_passager',
            'label_attr' => array(
                'class' => 'label-nb-passager'
            ),
            'choice_list' => $this->loadChoiceList("nbPassager"),
            'attr' => array(
                "class" => "select-nb-passager"
            )
        ))
            ->add('portDepart', 'choice', array(
            "choices" => $this->fillPortDepart(),
            'label' => 'form_sejour_portdepart',
            'attr' => array(
                'class' => 'select-portdepart'
            ),
            'empty_value' => "toutes"
        ))
            ->add('destination', 'choice', array(
            "choices" => $this->fillDestination(),
            'label' => 'form_sejour_destination',
            'attr' => array(
                'class' => 'select-destination'
            ),
            'empty_value' => "toutes"
        ))
            ->add('message', 'textarea', array(
            'label' => 'form_sejour_message',
            'label_attr' => array(
                'class' => 'label-textarea-message'
            ),
            'attr' => array(
                'class' => 'textarea-message'
            )
        ))
            ->add('nom', 'text', array(
            'label' => 'form_sejour_nom',
            'label_attr' => array(
                'class' => 'label-nom'
            ),
            'attr' => array(
                'class' => 'input-nom'
            )
        ))
            ->add('email', 'email', array(
            'label' => 'form_sejour_email',
            'label_attr' => array(
                'class' => 'label-email'
            ),
            'attr' => array(
                'class' => 'input-email'
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
        } elseif ($type == "dureeCroisiere") {
            $results = $this->em->getRepository("AppBundle\Entity\Croisiere")
                ->createQueryBuilder('c')
                ->select('c,tc')
                ->join('c.tarifCroisiere', 'tc')
                ->where('c.bateau = :id')
                ->setParameter(":id", $this->id)
                ->orderBy("tc.nombreJourMinimum", 'ASC')
                ->getQuery()
                ->getResult();
            $item = array(
                '' => '-'
            );
            if (count($results) > 0) {
                $nbJourMinimum = $results[0]->getTarifCroisiere()[0]->getNombreJourMinimum();
                $nbJourMaximum = 0;
                foreach ($results[0]->getTarifCroisiere() as $result) {
                    $nbJourMaximum = $result->getNombreJourMaximum() > $nbJourMaximum ? $result->getNombreJourMaximum() : $nbJourMaximum;
                }
                $item = array(
                    '' => '-'
                ) + array_combine(range($nbJourMinimum, $nbJourMaximum), range($nbJourMinimum, $nbJourMaximum));
            }
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

    private function fillPortDepart()
    {
        $results = $this->em->getRepository("AppBundle\Entity\Croisiere")
            ->createQueryBuilder('c')
            ->select('t.translatable_id as id, t.name')
            ->join('c.itineraireCroisiere', 'ic')
            ->join('ic.itineraire', 'i')
            ->join('i.portDepart', 'd')
            ->join('d.translations', 't')
            ->where("t.locale = :locale")
            ->andWhere('c.bateau = :id')
            ->setParameter(":locale", $this->locale)
            ->setParameter(":id", $this->id)
            ->orderBy('t.name', 'ASC')
            ->getQuery()
            ->getResult();
        
        $portDepart = array();
        foreach ($results as $port) {
            $portDepart[$port['name']] = $port['name'];
        }
        
        return $portDepart;
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
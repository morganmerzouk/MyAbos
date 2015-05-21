<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\Query;
use AppBundle\Form\BateauDevisType;
use AppBundle\Entity\Devis;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;

class SkipperController extends Controller
{

    /**
     * @Route("/skippers", name="skippers")
     */
    public function indexAction()
    {
        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage->addMeta('name', 'keyword', $this->get('translator')
            ->trans("crews_meta_keywords"))
            ->addMeta('name', 'description', $this->get('translator')
            ->trans("crews_meta_description"));
        
        $locale = $this->getRequest()->getLocale();
        
        $skippers = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\Skipper")
            ->createQueryBuilder('s')
            ->select('s, t')
            ->join('s.translations', 't')
            ->andWhere('t.locale = :locale')
            ->setParameter(':locale', $locale)
            ->getQuery()
            ->getResult();
        return $this->render('AppBundle:Front:Skipper/skippers.html.twig', array(
            'skippers' => $skippers
        ));
    }

    /**
     * @Route("/skipper/{id}/{slug}", requirements={"id" = "\d+"}, name="skipper")
     */
    public function skipperAction($id)
    {
        $seoPage = $this->container->get('sonata.seo.page');
        
        $locale = $this->getRequest()->getLocale();
        
        $skipper = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\Skipper")
            ->createQueryBuilder('s')
            ->select('s, t')
            ->join('s.translations', 't')
            ->where('s.id = :id')
            ->setParameter(':id', $id)
            ->andWhere('t.locale = :locale')
            ->setParameter(':locale', $locale)
            ->getQuery()
            ->getSingleResult();
        
        $offreSpeciale = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\OffreSpeciale")
            ->createQueryBuilder('os')
            ->select('os, b, ost, bt')
            ->join('AppBundle\Entity\Bateau', 'b', 'WITH', 'os.bateau = b.id')
            ->join('os.translations', 'ost')
            ->join('b.translations', 'bt')
            ->where('os.skipper = :id')
            ->setParameter(':id', $id)
            ->andWhere('bt.locale = :locale')
            ->andWhere('ost.locale = :locale')
            ->setParameter(':locale', $locale)
            ->getQuery()
            ->getResult(Query::HYDRATE_OBJECT);
        
        $croisiere = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\Croisiere")
            ->createQueryBuilder('c')
            ->select('c, b, t')
            ->join('AppBundle\Entity\Bateau', 'b', 'WITH', 'c.bateau = b.id')
            ->join('b.translations', 't')
            ->where('c.skipper = :id')
            ->setParameter(':id', $id)
            ->andWhere('t.locale = :locale')
            ->setParameter(':locale', $locale)
            ->getQuery()
            ->getResult(Query::HYDRATE_OBJECT);
        
        $seoPage->addMeta('name', 'keyword', $skipper->getName() . ',' . $this->get('translator')
            ->trans("crew_meta_keywords"));
        $seoPage->addMeta('name', 'description', substr(strip_tags($skipper->getDescription()), 0, 255));
        
        $croisiere2 = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\Croisiere")
            ->createQueryBuilder('c')
            ->select('c, ic, i, pd, d')
            ->join('c.itineraireCroisiere', 'ic')
            ->join('ic.itineraire', 'i')
            ->join('i.translations', 'it')
            ->join('i.portDepart', 'pd')
            ->join('pd.translations', 'pdt')
            ->join('i.destination', 'd')
            ->join('d.translations', 'dt')
            ->where('c.skipper = :id')
            ->andWhere('it.locale = :locale')
            ->andWhere('pdt.locale = :locale')
            ->andWhere('dt.locale = :locale')
            ->setParameter(':id', $id)
            ->setParameter(':locale', $locale)
            ->getQuery()
            ->getOneOrNullResult();
        
        $portDepart = null;
        if ($croisiere2 != null) {
            foreach ($croisiere2->getItineraireCroisiere() as $itineraireCroisiere) {
                if ($itineraireCroisiere->getParDefaut() == 1) {
                    $portDepart = $itineraireCroisiere->getItineraire()->getPortDepart();
                }
            }
        }
        
        $form = $this->createForm(new BateauDevisType($this->getDoctrine()
            ->getManager(), $this->getRequest()
            ->getLocale()));
        $form->handleRequest($this->getRequest());
        
        return $this->render('AppBundle:Front:Skipper/skipper.html.twig', array(
            'skipper' => $skipper,
            'id' => $id,
            'offrespeciale' => isset($offreSpeciale[0]) ? $offreSpeciale[0] : null,
            'boat' => isset($croisiere[0]) ? $croisiere[0]->getBateau() : null,
            'skipper_id' => isset($croisiere[0]) ? $croisiere[0]->getSkipper()
                ->getId() : null,
            'itinerairesCroisiere' => $croisiere2 != null ? $croisiere2->getItineraireCroisiere() : null,
            'datesNonDisponibilite' => isset($croisiere[0]) ? $croisiere[0]->getDateNonDisponibilite() : null,
            'portDepart' => $portDepart,
            'tarifs' => isset($croisieres[0]) ? $croisiere[0]->getTarifCroisiere() : null,
            'servicepayant' => isset($croisieres[0]) ? $croisiere[0]->getServicePayant() : null,
            'inclusprixavitaillement' => isset($croisieres[0]) ? $croisiere[0]->getBateau()
                ->getInclusPrixAvitaillement() : null,
            'inclusprixequipage' => isset($croisieres[0]) ? $croisiere[0]->getBateau()
                ->getInclusPrixEquipage() : null,
            'inclusprixfraisdevoyage' => isset($croisieres[0]) ? $croisiere[0]->getBateau()
                ->getInclusPrixFraisVoyage() : null,
            'inclusprixautresservices' => isset($croisieres[0]) ? $croisiere[0]->getBateau()
                ->getInclusPrixAutresServices() : null,
            'inclusprixequipement' => isset($croisieres[0]) ? $croisiere[0]->getBateau()
                ->getInclusPrixEquipement() : null,
            'inclusprixactivite' => isset($croisieres[0]) ? $croisiere[0]->getBateau()
                ->getInclusPrixActivite() : null,
            'inclusprixcours' => isset($croisieres[0]) ? $croisiere[0]->getBateau()
                ->getInclusPrixCours() : null,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/skipper/{id}/contact/step2/{bateauId}", requirements={"id" = "\d+"}, name="skipper_contact_step2")
     */
    public function skipperContactStep2Action($id, $bateauId)
    {
        $locale = $this->getRequest()->getLocale();
        $form = $this->createForm(new BateauDevisType($this->getDoctrine()
            ->getManager(), $this->getRequest()
            ->getLocale(), $bateauId));
        
        $form->handleRequest($this->getRequest());
        
        $skipper = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\Skipper")
            ->createQueryBuilder('s')
            ->select('s, t')
            ->join('s.translations', 't')
            ->where('s.id = :id')
            ->setParameter(':id', $id)
            ->andWhere('t.locale = :locale')
            ->setParameter(':locale', $locale)
            ->getQuery()
            ->getSingleResult();
        $bateau = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\Bateau")
            ->createQueryBuilder('s')
            ->select('s, t')
            ->join('s.translations', 't')
            ->where('s.id = :id')
            ->setParameter(':id', $bateauId)
            ->andWhere('t.locale = :locale')
            ->setParameter(':locale', $locale)
            ->getQuery()
            ->getSingleResult();
        
        if ($form->isValid()) {
            $session = $this->get('session');
            $data = $form->getData();
            $data['skipper'] = $skipper->getName();
            $data['bateau'] = $bateau->getName();
            if ($this->getRequest()->get('servicepayant')) {
                $servicePayant_id = array_values($this->getRequest()->get('servicepayant'));
                $servicePayant = $this->getDoctrine()
                    ->getManager()
                    ->getRepository("AppBundle\Entity\ServicePayant")
                    ->createQueryBuilder('sp')
                    ->select('sp, t')
                    ->join('sp.translations', 't')
                    ->where('sp.id IN (:id)')
                    ->andWhere('t.locale = :locale')
                    ->setParameter(':locale', $locale)
                    ->setParameter(':id', $servicePayant_id)
                    ->getQuery()
                    ->getResult();
                $session->set('servicePayant', $servicePayant);
            }
            $session->set('data', $data);
        }
        
        return $this->render('AppBundle:Front:Skipper/skipper_contact_step2.html.twig', array(
            'recap' => $data,
            'servicepayant' => $servicePayant,
            'locale' => $locale,
            'boat_id' => $bateauId,
            'skipper_name' => $skipper->getName()
        ));
    }

    /**
     * @Route("/skipper/{id}/contact/step3/", requirements={"id" = "\d+"}, name="skipper_contact_step3")
     */
    public function skipperContactStep3Action($id)
    {
        $session = $this->get('session');
        $data = $session->get('data');
        $servicePayant = $session->get('servicePayant');
        
        if ($data != null && $servicePayant != null) {
            $formatPattern = $this->getRequest()->getLocale() == "en" ? "M/d/Y" : "d/M/Y";
            $devis = new Devis();
            $devis->setDateDebut($data['dateDepart']->format($formatPattern))
                ->setDateFin($data['dateRetour']->format($formatPattern))
                ->setNbPassager($data['nbPassager'])
                ->setDureeCroisiere($data['dureeCroisiere'])
                ->setPortDepart($data['portDepart'])
                ->setDestination($data['destination'])
                ->setMessage($data['message'])
                ->setNom($data['nom'])
                ->setEmail($data['email'])
                ->setPrix($data['prix'])
                ->setSkipper($data['skipper'])
                ->setBateau($data['bateau'])
                ->setCreatedAt(new \Datetime('now'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($devis);
            $em->flush();
        }
        
        return new Response("");
    }

    public function subMenuAction($route, $id)
    {
        $locale = $this->getRequest()->getLocale();
        
        $skipper = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\Skipper")
            ->createQueryBuilder('s')
            ->select('s, t')
            ->join('s.translations', 't')
            ->where('s.id = :id')
            ->setParameter(':id', $id)
            ->andWhere('t.locale = :locale')
            ->setParameter(':locale', $locale)
            ->getQuery()
            ->getSingleResult();
        
        return $this->render('AppBundle:Front:Skipper/skipper_submenu.html.twig', array(
            'skipper' => $skipper
        ));
    }
}

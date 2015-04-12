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
     * @Route("/skipper/{id}", requirements={"id" = "\d+"}, name="skipper")
     */
    public function skipperAction($id)
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
        
        return $this->render('AppBundle:Front:Skipper/skipper_presentation.html.twig', array(
            'skipper' => $skipper,
            'id' => $id,
            'offrespeciale' => isset($offreSpeciale[0]) ? $offreSpeciale[0] : null
        ));
    }

    /**
     * @Route("/skipper/{id}/bateaux", requirements={"id" = "\d+"}, name="skipper_bateaux")
     */
    public function skipperFlottesAction($id)
    {
        $locale = $this->getRequest()->getLocale();
        
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
        return $this->render('AppBundle:Front:Skipper/skipper_bateau.html.twig', array(
            'boat' => ($croisiere[0]->getBateau()),
            'skipper_id' => $croisiere[0]->getSkipper()
                ->getId()
        ));
    }

    /**
     * @Route("/skipper/{id}/destination", requirements={"id" = "\d+"}, name="skipper_desti")
     */
    public function skipperDestiAction($id)
    {
        $locale = $this->getRequest()->getLocale();
        
        $croisiere = $this->getDoctrine()
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
        if ($croisiere != null) {
            foreach ($croisiere->getItineraireCroisiere() as $itineraireCroisiere) {
                if ($itineraireCroisiere->getParDefaut() == 1) {
                    $portDepart = $itineraireCroisiere->getItineraire()->getPortDepart();
                }
            }
        }
        
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
        
        return $this->render('AppBundle:Front:Skipper/skipper_desti.html.twig', array(
            'portDepart' => $portDepart,
            'itinerairesCroisiere' => $croisiere != null ? $croisiere->getItineraireCroisiere() : null,
            'offrespeciale' => isset($offreSpeciale[0]) ? $offreSpeciale[0] : null
        ));
    }

    /**
     * @Route("/skipper/{id}/disponibilite", requirements={"id" = "\d+"}, name="skipper_available")
     */
    public function skipperAvailableAction($id)
    {
        $croisieres = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\Croisiere")
            ->createQueryBuilder('c')
            ->select('c,d')
            ->join('c.skipper', 's')
            ->join('c.dateNonDisponibilite', 'd')
            ->where('s.id = :id')
            ->setParameter(':id', $id)
            ->getQuery()
            ->getResult(Query::HYDRATE_OBJECT);
        
        return $this->render('AppBundle:Front:Skipper/skipper_available.html.twig', array(
            'datesNonDisponibilite' => isset($croisieres[0]) ? $croisieres[0]->getDateNonDisponibilite() : null
        ));
    }

    /**
     * @Route("/skipper/{id}/price", requirements={"id" = "\d+"}, name="skipper_price")
     */
    public function skipperPriceAction($id)
    {
        $locale = $this->getRequest()->getLocale();
        
        $croisiere = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\Croisiere")
            ->createQueryBuilder('c')
            ->select('c, t')
            ->join('c.tarifCroisiere', 't')
            ->where('c.skipper = :id')
            ->setParameter(':id', $id)
            ->getQuery()
            ->getOneOrNullResult();
        
        return $this->render('AppBundle:Front:Skipper/skipper_price.html.twig', array(
            'tarifs' => $croisiere != null ? $croisiere->getTarifCroisiere() : null,
            'servicepayant' => $croisiere != null ? $croisiere->getServicePayant() : null,
            'inclusprixavitaillement' => $croisiere != null ? $croisiere->getBateau()
                ->getInclusPrixAvitaillement() : null,
            'inclusprixequipage' => $croisiere != null ? $croisiere->getBateau()
                ->getInclusPrixEquipage() : null,
            'inclusprixfraisdevoyage' => $croisiere != null ? $croisiere->getBateau()
                ->getInclusPrixFraisVoyage() : null,
            'inclusprixautresservices' => $croisiere != null ? $croisiere->getBateau()
                ->getInclusPrixAutresServices() : null,
            'inclusprixequipement' => $croisiere != null ? $croisiere->getBateau()
                ->getInclusPrixEquipement() : null,
            'inclusprixactivite' => $croisiere != null ? $croisiere->getBateau()
                ->getInclusPrixActivite() : null,
            'inclusprixcours' => $croisiere != null ? $croisiere->getBateau()
                ->getInclusPrixCours() : null
        ));
    }

    /**
     * @Route("/skipper/{id}/contact", requirements={"id" = "\d+"}, name="skipper_contact")
     */
    public function skipperContactAction($id)
    {
        $locale = $this->getRequest()->getLocale();
        $form = $this->createForm(new BateauDevisType($this->getDoctrine()
            ->getEntityManager(), $this->getRequest()
            ->getLocale()));
        $form->handleRequest($this->getRequest());
        
        if ($form->isValid()) {
            $data = $form->getData();
            var_dump($data);
        }
        
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
        
        return $this->render('AppBundle:Front:Skipper/skipper_contact.html.twig', array(
            'form' => $form->createView(),
            'skipper' => isset($croisiere[0]) ? $croisiere[0]->getSkipper() : null,
            'locale' => $locale
        ));
    }

    /**
     * @Route("/skipper/{id}/contact/step2/{bateauId}", requirements={"id" = "\d+"}, name="skipper_contact_step2")
     */
    public function skipperContactStep2Action($id, $bateauId)
    {
        $locale = $this->getRequest()->getLocale();
        $form = $this->createForm(new BateauDevisType($this->getDoctrine()
            ->getEntityManager(), $this->getRequest()
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
            'skipper' => $skipper,
            'route' => $route
        ));
    }
}

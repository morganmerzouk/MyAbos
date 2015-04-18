<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\Query;
use AppBundle\Form\BateauDevisType;
use AppBundle\Entity\Devis;
use Symfony\Component\HttpFoundation\Response;

class BateauController extends Controller
{

    /**
     * @Route("/bateaux", name="boats")
     */
    public function indexAction()
    {
        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage->addMeta('name', 'keyword', $this->get('translator')
            ->trans("fleet_meta_keywords"))
            ->addMeta('name', 'description', $this->get('translator')
            ->trans("fleet_meta_description"));
        
        $locale = $this->getRequest()->getLocale();
        $croisieres = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\Croisiere")
            ->createQueryBuilder('s')
            ->select('s, t')
            ->join('s.translations', 't')
            ->andWhere('t.locale = :locale')
            ->setParameter(':locale', $locale)
            ->getQuery()
            ->getResult();
        return $this->render('AppBundle:Front:Bateau/boats.html.twig', array(
            'croisieres' => $croisieres
        ));
    }

    /**
     * @Route("/bateau/{id}", requirements={"id" = "\d+"}, name="boat")
     */
    public function bateauAction($id)
    {
        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage->addMeta('name', 'keyword', $this->get('translator')
            ->trans("fleet_overview_meta_keywords"))
            ->addMeta('name', 'description', $this->get('translator')
            ->trans("fleet_overview_meta_description"));
        
        $locale = $this->getRequest()->getLocale();
        
        $boat = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\Bateau")
            ->createQueryBuilder('s')
            ->select('s, t')
            ->join('s.translations', 't')
            ->where('s.id = :id')
            ->setParameter(':id', $id)
            ->andWhere('t.locale = :locale')
            ->setParameter(':locale', $locale)
            ->getQuery()
            ->getSingleResult();
        $seoPage->addMeta('name', 'keyword', $boat->getType() . ' ' . $boat->getName());
        $seoPage->addMeta('name', 'description', substr($boat->getDescription(), 0, 255));
        
        $inclusPrix = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\Bateau")
            ->createQueryBuilder('b')
            ->select('b, ipe, ipa, ipf, ipet, ipac, ipc, ipas')
            ->leftJoin('b.inclusPrixEquipage', 'ipe')
            ->leftJoin('b.inclusPrixAvitaillement', 'ipa')
            ->leftJoin('b.inclusPrixFraisVoyage', 'ipf')
            ->leftJoin('b.inclusPrixEquipement', 'ipet')
            ->leftJoin('b.inclusPrixActivite', 'ipac')
            ->leftJoin('b.inclusPrixCours', 'ipc')
            ->leftJoin('b.inclusPrixAutresServices', 'ipas')
            ->where('b.id = :id')
            ->setParameter(':id', $id)
            ->getQuery()
            ->getResult();
        
        $ids = array();
        
        if (isset($inclusPrix[0]) && $inclusPrix[0]->getInclusPrixEquipage() != null)
            array_push($ids, $inclusPrix[0]->getInclusPrixEquipage()->getId());
        foreach ($inclusPrix[0]->getInclusPrixAvitaillement() as $inclusPrixAvitaillement)
            array_push($ids, $inclusPrixAvitaillement->getId());
        foreach ($inclusPrix[0]->getInclusPrixFraisVoyage() as $inclusPrixFraisVoyage)
            array_push($ids, $inclusPrixFraisVoyage->getId());
        foreach ($inclusPrix[0]->getInclusPrixEquipement() as $inclusPrixEquipement)
            array_push($ids, $inclusPrixEquipement->getId());
        foreach ($inclusPrix[0]->getInclusPrixActivite() as $inclusPrixActivite)
            array_push($ids, $inclusPrixActivite->getId());
        foreach ($inclusPrix[0]->getInclusPrixCours() as $inclusPrixCours)
            array_push($ids, $inclusPrixCours->getId());
        foreach ($inclusPrix[0]->getInclusPrixAutresServices() as $inclusPrixAutresServices)
            array_push($ids, $inclusPrixAutresServices->getId());
        
        $inclusPrix = $this->getDoctrine()
            ->getManager()
            ->createQueryBuilder('ip')
            ->select('ip,p,pt')
            ->from("AppBundle\Entity\InclusPrix", "ip")
            ->join('ip.prestation', 'p')
            ->join('p.translations', 'pt')
            ->andWhere('pt.locale = :locale')
            ->andWhere('ip.id IN (' . implode(',', $ids) . ')')
            ->setParameter(':locale', $locale)
            ->getQuery()
            ->getResult();
        if (count($inclusPrix) > 0) {
            $idPrestations = array();
            foreach ($inclusPrix[0]->getPrestation() as $prestation) {
                array_push($idPrestations, $prestation->getId());
            }
            
            $prestation = $this->getDoctrine()
                ->getManager()
                ->createQueryBuilder('p')
                ->select('p,pt')
                ->from("AppBundle\Entity\Prestation", "p")
                ->join('p.translations', 'pt')
                ->andWhere('pt.locale = :locale')
                ->andWhere('p.id IN (' . implode(',', $idPrestations) . ')')
                ->setParameter(':locale', $locale)
                ->getQuery()
                ->getResult();
        } else {
            $prestation = null;
        }
        return $this->render('AppBundle:Front:Bateau/boat_presentation.html.twig', array(
            'boat' => $boat,
            'prestations' => $prestation
        ));
    }

    /**
     * @Route("/bateau/{id}/details", requirements={"id" = "\d+"}, name="boat_details")
     */
    public function bateauDetailAction($id)
    {
        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage->addMeta('name', 'keyword', $this->get('translator')
            ->trans("fleet_spec_meta_keywords"))
            ->addMeta('name', 'description', $this->get('translator')
            ->trans("fleet_spec_meta_description"));
        
        $locale = $this->getRequest()->getLocale();
        
        $boat = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\Bateau")
            ->createQueryBuilder('s')
            ->select('s, t')
            ->join('s.translations', 't')
            ->where('s.id = :id')
            ->setParameter(':id', $id)
            ->andWhere('t.locale = :locale')
            ->setParameter(':locale', $locale)
            ->getQuery()
            ->getSingleResult();
        
        $croisiere = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\Croisiere")
            ->createQueryBuilder('c')
            ->select('c, b, t')
            ->join('AppBundle\Entity\Bateau', 'b', 'WITH', 'c.bateau = b.id')
            ->join('b.translations', 't')
            ->where('c.bateau = :id')
            ->setParameter(':id', $id)
            ->andWhere('t.locale = :locale')
            ->setParameter(':locale', $locale)
            ->getQuery()
            ->getResult(Query::HYDRATE_OBJECT);
        
        return $this->render('AppBundle:Front:Bateau/boat_details.html.twig', array(
            'boat' => $boat,
            'skipper' => isset($croisiere[0]) ? $croisiere[0]->getSkipper() : null
        ));
    }

    /**
     * @Route("/bateau/{id}/crew", requirements={"id" = "\d+"}, name="boat_crew")
     */
    public function bateauCrewAction($id)
    {
        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage->addMeta('name', 'keyword', $this->get('translator')
            ->trans("fleet_crew_meta_keywords"))
            ->addMeta('name', 'description', $this->get('translator')
            ->trans("fleet_crew_meta_description"));
        $locale = $this->getRequest()->getLocale();
        
        $boat = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\Bateau")
            ->createQueryBuilder('s')
            ->select('s, t')
            ->join('s.translations', 't')
            ->where('s.id = :id')
            ->setParameter(':id', $id)
            ->andWhere('t.locale = :locale')
            ->setParameter(':locale', $locale)
            ->getQuery()
            ->getSingleResult();
        
        $croisiere = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\Croisiere")
            ->createQueryBuilder('c')
            ->select('c, b, t')
            ->join('AppBundle\Entity\Bateau', 'b', 'WITH', 'c.bateau = b.id')
            ->join('b.translations', 't')
            ->where('c.bateau = :id')
            ->setParameter(':id', $id)
            ->andWhere('t.locale = :locale')
            ->setParameter(':locale', $locale)
            ->getQuery()
            ->getResult(Query::HYDRATE_OBJECT);
        
        $offreSpeciale = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\OffreSpeciale")
            ->createQueryBuilder('os')
            ->select('os, b, ost, bt')
            ->join('AppBundle\Entity\Bateau', 'b', 'WITH', 'os.bateau = b.id')
            ->join('os.translations', 'ost')
            ->join('b.translations', 'bt')
            ->where('os.bateau = :id')
            ->setParameter(':id', $id)
            ->andWhere('bt.locale = :locale')
            ->andWhere('ost.locale = :locale')
            ->setParameter(':locale', $locale)
            ->getQuery()
            ->getResult(Query::HYDRATE_OBJECT);
        
        return $this->render('AppBundle:Front:Bateau/boat_crew.html.twig', array(
            'boat' => $boat,
            'skipper' => isset($croisiere[0]) ? $croisiere[0]->getSkipper() : null,
            'offrespeciale' => isset($offreSpeciale[0]) ? $offreSpeciale[0] : null
        ));
    }

    /**
     * @Route("/bateau/{id}/available", requirements={"id" = "\d+"}, name="boat_available")
     */
    public function bateauAvailableAction($id)
    {
        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage->addMeta('name', 'keyword', $this->get('translator')
            ->trans("fleet_availability_meta_keywords"))
            ->addMeta('name', 'description', $this->get('translator')
            ->trans("fleet_availability_meta_description"));
        
        $croisieres = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\Croisiere")
            ->createQueryBuilder('c')
            ->select('c,d')
            ->join('c.bateau', 'b')
            ->join('c.dateNonDisponibilite', 'd')
            ->where('b.id = :id')
            ->setParameter(':id', $id)
            ->getQuery()
            ->getResult(Query::HYDRATE_OBJECT);
        return $this->render('AppBundle:Front:Bateau/boat_available.html.twig', array(
            'datesNonDisponibilite' => isset($croisieres[0]) ? $croisieres[0]->getDateNonDisponibilite() : null
        ));
    }

    /**
     * @Route("/bateau/{id}/destination", requirements={"id" = "\d+"}, name="boat_destination")
     */
    public function bateauDestiAction($id)
    {
        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage->addMeta('name', 'keyword', $this->get('translator')
            ->trans("fleet_destination_meta_keywords"))
            ->addMeta('name', 'description', $this->get('translator')
            ->trans("fleet_destination_meta_description"));
        
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
            ->where('c.bateau = :id')
            ->andWhere('it.locale = :locale')
            ->andWhere('pdt.locale = :locale')
            ->andWhere('dt.locale = :locale')
            ->setParameter(':id', $id)
            ->setParameter(':locale', $locale)
            ->getQuery()
            ->getOneOrNullResult();
        
        $portDepart = null;
        foreach ($croisiere->getItineraireCroisiere() as $itineraireCroisiere) {
            if ($itineraireCroisiere->getParDefaut() == 1) {
                $portDepart = $itineraireCroisiere->getItineraire()->getPortDepart();
            }
        }
        
        return $this->render('AppBundle:Front:Bateau/boat_desti.html.twig', array(
            'portDepart' => $portDepart,
            'itinerairesCroisiere' => $croisiere->getItineraireCroisiere()
        ));
    }

    /**
     * @Route("/bateau/{id}/price", requirements={"id" = "\d+"}, name="boat_price")
     */
    public function bateauPriceAction($id)
    {
        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage->addMeta('name', 'keyword', $this->get('translator')
            ->trans("fleet_price_meta_keywords"))
            ->addMeta('name', 'description', $this->get('translator')
            ->trans("fleet_price_meta_description"));
        $locale = $this->getRequest()->getLocale();
        
        $croisiere = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\Croisiere")
            ->createQueryBuilder('c')
            ->select('c, t')
            ->join('c.tarifCroisiere', 't')
            ->where('c.bateau = :id')
            ->setParameter(':id', $id)
            ->getQuery()
            ->getOneOrNullResult();
        
        $boat = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\Bateau")
            ->createQueryBuilder('s')
            ->select('s, t')
            ->join('s.translations', 't')
            ->where('s.id = :id')
            ->setParameter(':id', $id)
            ->andWhere('t.locale = :locale')
            ->setParameter(':locale', $locale)
            ->getQuery()
            ->getOneOrNullResult();
        return $this->render('AppBundle:Front:Bateau/boat_price.html.twig', array(
            'tarifs' => $croisiere != null ? $croisiere->getTarifCroisiere() : null,
            'servicepayant' => $croisiere != null ? $croisiere->getServicePayant() : null,
            'inclusprixavitaillement' => $boat->getInclusPrixAvitaillement(),
            'inclusprixequipage' => $boat->getInclusPrixEquipage(),
            'inclusprixfraisdevoyage' => $boat->getInclusPrixFraisVoyage(),
            'inclusprixautresservices' => $boat->getInclusPrixAutresServices(),
            'inclusprixequipement' => $boat->getInclusPrixEquipement(),
            'inclusprixactivite' => $boat->getInclusPrixActivite(),
            'inclusprixcours' => $boat->getInclusPrixCours()
        ));
    }

    /**
     * @Route("/bateau/{id}/contact", requirements={"id" = "\d+"}, name="boat_contact")
     */
    public function bateauContactAction($id)
    {
        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage->addMeta('name', 'keyword', $this->get('translator')
            ->trans("fleet_contact_meta_keywords"))
            ->addMeta('name', 'description', $this->get('translator')
            ->trans("fleet_contact_meta_description"));
        $locale = $this->getRequest()->getLocale();
        $form = $this->createForm(new BateauDevisType($this->getDoctrine()
            ->getManager(), $this->getRequest()
            ->getLocale(), $id));
        
        $croisiere = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\Croisiere")
            ->createQueryBuilder('c')
            ->select('c, b, t')
            ->join('AppBundle\Entity\Bateau', 'b', 'WITH', 'c.bateau = b.id')
            ->join('b.translations', 't')
            ->where('c.bateau = :id')
            ->setParameter(':id', $id)
            ->andWhere('t.locale = :locale')
            ->setParameter(':locale', $locale)
            ->getQuery()
            ->getResult(Query::HYDRATE_OBJECT);
        
        return $this->render('AppBundle:Front:Bateau/boat_contact.html.twig', array(
            'form' => $form->createView(),
            'skipper' => isset($croisiere[0]) ? $croisiere[0]->getSkipper() : null,
            'servicepayant' => isset($croisiere[0]) ? $croisiere[0]->getServicePayant() : null
        ));
    }

    /**
     * @Route("/bateau/{id}/contact/step2/{skipperId}", requirements={"id" = "\d+"}, name="boat_contact_step2")
     */
    public function boatContactStep2Action($id, $skipperId)
    {
        $locale = $this->getRequest()->getLocale();
        $form = $this->createForm(new BateauDevisType($this->getDoctrine()
            ->getManager(), $this->getRequest()
            ->getLocale(), $id));
        
        $form->handleRequest($this->getRequest());
        
        $skipper = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\Skipper")
            ->createQueryBuilder('s')
            ->select('s, t')
            ->join('s.translations', 't')
            ->where('s.id = :id')
            ->setParameter(':id', $skipperId)
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
            ->setParameter(':id', $id)
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
        
        return $this->render('AppBundle:Front:Bateau/boat_contact_step2.html.twig', array(
            'recap' => $data,
            'servicepayant' => $servicePayant,
            'locale' => $locale,
            'boat_id' => $id,
            'skipper_name' => $skipper->getName()
        ));
    }

    /**
     * @Route("/bateau/{id}/contact/step3/", requirements={"id" = "\d+"}, name="boat_contact_step3")
     */
    public function boatContactStep3Action($id)
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

    /**
     * @Route("/bateau/{id}/contact/price/{nbPassager}/{nbDays}/{dateDepart}/{dateFin}", requirements={"id" = "\d+"}, defaults={"nbPassager" = 0, "nbDays" = 0, "dateDepart" = 0, "dateFin" = 0}, name="boat_contact_price")
     */
    public function bateauContactPriceAction($id, $nbPassager = 0, $nbDays = 0, $dateDepart = 0, $dateFin = 0)
    {
        $croisiere = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\Croisiere")
            ->createQueryBuilder('c')
            ->select('c, tc')
            ->join('c.tarifCroisiere', 'tc')
            ->where('c.bateau = :id')
            ->setParameter(':id', $id);
        
        $locale = $this->getRequest()->getLocale();
        
        $formatPattern = $locale == "en" ? 'm/d/Y' : 'd/m/Y';
        $formatPatternSql = $locale == "en" ? 'm-d-Y' : 'd-m-Y';
        
        if ($dateDepart != 0) {
            $dateDepart = \DateTime::createFromFormat($formatPatternSql, $dateDepart);
            $croisiere->andWhere("(tc.dateDebut < :dateDepart AND tc.dateFin > :dateDepart)")->setParameter(":dateDepart", $dateDepart->format('Y-m-d'));
        }
        if ($dateFin != 0) {
            $dateFin = \DateTime::createFromFormat($formatPatternSql, $dateFin);
            if ($dateDepart) {
                $croisiere->orWhere("(tc.dateDebut < :dateFin AND tc.dateFin > :dateFin)")->setParameter(":dateFin", $dateFin->format('Y-m-d'));
            } else {
                $croisiere->andWhere("(tc.dateDebut < :dateFin AND tc.dateFin > :dateFin)")->setParameter(":dateFin", $dateFin->format('Y-m-d'));
            }
        }
        if ($nbDays != 0) {
            $croisiere->andWhere("tc.nombreJourMinimum <= :nbDays")
                ->andWhere("tc.nombreJourMaximum >= :nbDays")
                ->setParameter(":nbDays", $nbDays);
        }
        $croisiere = $croisiere->getQuery()->getOneOrNullResult();
        if ($croisiere == null) {
            return new Response("N/A");
        }
        
        $tarif = $croisiere->getTarifCroisiere();
        // Y a chevauchement de date, on vérifie que les prix diffèrent bien
        if (count($tarif) == 2 && $this->getPricePerPassenger($nbPassager, $tarif[0]) != $this->getPricePerPassenger($nbPassager, $tarif[1])) {
            $tarifPersonne = "<br />";
            foreach ($tarif as $tarifPeriode) {
                $tarifPersonne .= $this->getPricePerPassengerPerDay($nbPassager, $tarifPeriode) . ' ' . $this->get('translator')->trans('from') . ' ' . ($dateDepart > $tarifPeriode->getDateDebut() ? $dateDepart->format($formatPattern) : $tarifPeriode->getDateDebut()->format($formatPattern)) . ' ' . $this->get('translator')->trans('to') . ' ' . ($dateFin > $tarifPeriode->getDateFin() ? $tarifPeriode->getDateFin()->format($formatPattern) : $dateFin->format($formatPattern)) . '<br />';
            }
        } else {
            $tarifPersonne = $this->getPricePerPassengerPerDay($nbPassager, $tarif[0]);
        }
        
        return new Response($tarifPersonne);
    }

    function getPricePerPassenger($nbPassager, $tarif)
    {
        switch ($nbPassager) {
            case '2':
                $tarifPersonne = $tarif->getTarifDeuxPersonnes();
                break;
            case '3':
                $tarifPersonne = $tarif->getTarifTroisPersonnes();
                break;
            case '4':
                $tarifPersonne = $tarif->getTarifQuatrePersonnes();
                break;
            case '5':
                $tarifPersonne = $tarif->getTarifCinqPersonnes();
                break;
            case '6':
                $tarifPersonne = $tarif->getTarifSixPersonnes();
                break;
            case '7':
                $tarifPersonne = $tarif->getTarifSeptPersonnes();
                break;
            case '8':
                $tarifPersonne = $tarif->getTarifHuitPersonnes();
                break;
        }
    }

    function getPricePerPassengerPerDay($nbPassager, $tarif)
    {
        switch ($nbPassager) {
            case '2':
                $tarifPersonne = $tarif->getTarifDeuxPersonnes();
                break;
            case '3':
                $tarifPersonne = $tarif->getTarifTroisPersonnes();
                break;
            case '4':
                $tarifPersonne = $tarif->getTarifQuatrePersonnes();
                break;
            case '5':
                $tarifPersonne = $tarif->getTarifCinqPersonnes();
                break;
            case '6':
                $tarifPersonne = $tarif->getTarifSixPersonnes();
                break;
            case '7':
                $tarifPersonne = $tarif->getTarifSeptPersonnes();
                break;
            case '8':
                $tarifPersonne = $tarif->getTarifHuitPersonnes();
                break;
        }
        switch ($tarif->getTarifPour()) {
            case "1 day/boat":
                $tarifPersonne = round($tarifPersonne / $nbPassager, 2);
                break;
            case "7 days/boat":
                $tarifPersonne = round($tarifPersonne / 7 / $nbPassager, 2);
                break;
            case "10 days/boat":
                $tarifPersonne = round($tarifPersonne / 10 / $nbPassager, 2);
                break;
            case "1 day/passenger":
                $tarifPersonne = round($tarifPersonne, 2);
                break;
            case "7 days/passenger":
                $tarifPersonne = round($tarifPersonne / 7, 2);
                break;
            case "10 days/passenger":
                $tarifPersonne = round($tarifPersonne / 10, 2);
                break;
        }
        return $tarifPersonne;
    }

    public function subMenuAction($route, $id)
    {
        $request = $this->getRequest();
        $locale = $request->getLocale();
        
        $boat = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\Bateau")
            ->createQueryBuilder('s')
            ->select('s, t')
            ->join('s.translations', 't')
            ->where('s.id = :id')
            ->setParameter(':id', $id)
            ->andWhere('t.locale = :locale')
            ->setParameter(':locale', $locale)
            ->getQuery()
            ->getSingleResult();
        
        return $this->render('AppBundle:Front:Bateau/boat_submenu.html.twig', array(
            'boat' => $boat,
            'route' => $route
        ));
    }
}

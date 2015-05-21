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
            ->trans("fleets_meta_keywords"))
            ->addMeta('name', 'description', $this->get('translator')
            ->trans("fleets_meta_description"));
        
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
     * @Route("/bateau/{id}/{slug}", requirements={"id" = "\d+"}, name="boat")
     */
    public function bateauAction($id)
    {
        $seoPage = $this->container->get('sonata.seo.page');
        
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
            ->select('c, b, t, d, t2')
            ->join('AppBundle\Entity\Bateau', 'b', 'WITH', 'c.bateau = b.id')
            ->join('b.translations', 't')
            ->join('c.dateNonDisponibilite', 'd')
            ->join('c.tarifCroisiere', 't2')
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
        
        $seoPage->addMeta('name', 'keyword', $boat->getType() . ' ' . $boat->getName() . ',' . $this->get('translator')
            ->trans("fleet_meta_keywords"));
        $seoPage->addMeta('name', 'description', substr(strip_tags($boat->getDescription()), 0, 255));
        
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
            ->where('c.bateau = :id')
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
            ->getLocale(), $id));
        
        $form->handleRequest($this->getRequest());
        
        return $this->render('AppBundle:Front:Bateau/boat.html.twig', array(
            'boat' => $boat,
            'prestations' => $prestation,
            'skipper' => isset($croisiere[0]) ? $croisiere[0]->getSkipper() : null,
            'offrespeciale' => isset($offreSpeciale[0]) ? $offreSpeciale[0] : null,
            'datesNonDisponibilite' => isset($croisiere[0]) ? $croisiere[0]->getDateNonDisponibilite() : null,
            'portDepart' => $portDepart,
            'itinerairesCroisiere' => isset($croisiere2) ? $croisiere2->getItineraireCroisiere() : null,
            'tarifs' => isset($croisiere[0]) ? $croisiere[0]->getTarifCroisiere() : null,
            'servicepayant' => isset($croisiere[0]) ? $croisiere[0]->getServicePayant() : null,
            'inclusprixavitaillement' => $boat->getInclusPrixAvitaillement(),
            'inclusprixequipage' => $boat->getInclusPrixEquipage(),
            'inclusprixfraisdevoyage' => $boat->getInclusPrixFraisVoyage(),
            'inclusprixautresservices' => $boat->getInclusPrixAutresServices(),
            'inclusprixequipement' => $boat->getInclusPrixEquipement(),
            'inclusprixactivite' => $boat->getInclusPrixActivite(),
            'inclusprixcours' => $boat->getInclusPrixCours(),
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/bateau/{id}/contact", requirements={"id" = "\d+"}, name="boat_contact")
     */
    public function bateauContactAction($id)
    {
        $locale = $this->getRequest()->getLocale();
        
        $email = $this->getRequest()->request->get('email');
        $nom = $this->getRequest()->request->get('nom');
        $message = $this->getRequest()->request->get('message');
        
        $formatPattern = $this->getRequest()->getLocale() == "en" ? "m/d/Y" : "d/m/Y";
        $dateDepart = $this->getRequest()->request->get('dateDepart') != "" ? \DateTime::createFromFormat($formatPattern, $this->getRequest()->request->get('dateDepart')) : null;
        $dateRetour = $this->getRequest()->request->get('dateRetour') != "" ? \DateTime::createFromFormat($formatPattern, $this->getRequest()->request->get('dateRetour')) : null;
        
        if ($this->getRequest()->request->get('servicePayant')) {
            $servicePayant_id = array_values($this->getRequest()->request->get('servicePayant'));
            $servicesPayant = $this->getDoctrine()
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
            $html = "";
            foreach ($servicesPayant as $servicePayant) {
                $html .= $servicePayant->getName() . '<br />';
            }
        }
        
        $devis = new Devis();
        $devis->setDateDebut($dateDepart)
            ->setDateFin($dateRetour)
            ->setNom($nom)
            ->setMessage($message)
            ->setEmail($email)
            ->setNbPassager($this->getRequest()->request->get('nbPassager'))
            ->setDureeCroisiere($this->getRequest()->request->get('dureeCroisiere'))
            ->setPortDepart($this->getRequest()->request->get('portDepart'))
            ->setDestination($this->getRequest()->request->get('destination'))
            ->setCreatedAt(new \DateTime("now"));
        if (isset($html)) {
            $devis->setServicePayant($html);
        }
        
        $croisiere = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\Croisiere")
            ->createQueryBuilder('c')
            ->select('c, t')
            ->join('c.translations', 't')
            ->where('c.bateau = :id')
            ->setParameter(':id', $id)
            ->andWhere('t.locale = :locale')
            ->setParameter(':locale', $locale)
            ->getQuery()
            ->getSingleResult();
        
        $devis->setSkipper($croisiere->getSkipper())
            ->setBateau($croisiere->getBateau());
        $em = $this->getDoctrine()->getManager();
        $em->persist($devis);
        $em->flush();
        
        return new Response("OK");
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

    public function subMenuAction($id)
    {
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
        
        return $this->render('AppBundle:Front:Bateau/boat_submenu.html.twig', array(
            'boat' => $boat
        ));
    }
}

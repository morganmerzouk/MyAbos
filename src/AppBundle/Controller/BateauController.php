<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\Query;
use AppBundle\Form\BateauDevisType;
use Symfony\Component\HttpFoundation\Response;

class BateauController extends Controller
{

    /**
     * @Route("/bateaux", name="boats")
     */
    public function indexAction()
    {
        $request = $this->getRequest();
        $locale = $request->getLocale();
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
        
        $servicePayant = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\ServicePayant")
            ->createQueryBuilder('s')
            ->select('s, t')
            ->join('s.translations', 't')
            ->where('s.bateau = :id')
            ->orderby('s.categorie', 'ASC')
            ->setParameter(':id', $id)
            ->getQuery()
            ->getResult();
        
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
            'servicepayant' => $servicePayant,
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
        $locale = $this->getRequest()->getLocale();
        $form = $this->createForm(new BateauDevisType($this->getDoctrine()
            ->getEntityManager(), $this->getRequest()
            ->getLocale()));
        $form->handleRequest($this->getRequest());
        
        if ($form->isValid()) {
            $data = $form->getData();
            return $this->redirect($this->generateUrl('task_success'));
        }
        
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
            'skipper' => isset($croisiere[0]) ? $croisiere[0]->getSkipper() : null
        ));
    }
    
    /**
     * @Route("/bateau/{id}/contact/price/{nbPassager}/{nbDays}/{dateDepart}", requirements={"id" = "\d+"}, defaults={"nbPassager" = null, "nbDays" = null, "dateDepart" = null}, name="boat_contact_price")
     */
    public function bateauContactPriceAction($id, $nbPassager = null, $nbDays = null, $dateDepart = null)
    {
        
        $croisiere = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\Croisiere")
            ->createQueryBuilder('c')
            ->select('c, tc')
            ->join('c.tarifCroisiere', 'tc')
            ->where('c.bateau = :id')
            ->setParameter(':id', $id);
        
        $dateDepart = explode('-', $dateDepart)[2].'-'.explode('-', $dateDepart)[0].'-'.explode('-', $dateDepart)[1];
        
        if($dateDepart != null) {
            $croisiere->andWhere("tc.dateDebut < :dateDepart")
                        ->andWhere("tc.dateFin > :dateDepart")
                        ->setParameter(":dateDepart", $dateDepart);
        }
        if($nbDays != null) {
            $croisiere->andWhere("tc.nombreJourMinimum > :nbDays")
                        ->andWhere("tc.nombreJourMaximum > :nbDays")
                        ->setParameter(":nbDays", $nbDays);
        }
        
        $croisiere = $croisiere->getQuery()
                                ->getOneOrNullResult();
        
        $tarif = $croisiere->getTarifCroisiere();
        if(count($tarif)==1) {
            switch($nbPassager) {
                case '2':
                    $tarif->getTarifDeuxPersonne();
                break;
                case '3':
                    $tarif->getTarifTroisPersonne();
                break;
                case '4':
                    $tarif->getTarifQuatrePersonne();
                break;
                case '5':
                    $tarif->getTarifCinqPersonne();
                break;
                case '6':
                    $tarif->getTarifSixPersonne();
                break;
                case '7':
                break;
                case '8':
                break;
            }
        }
        return new Response(var_dump($tarif));
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

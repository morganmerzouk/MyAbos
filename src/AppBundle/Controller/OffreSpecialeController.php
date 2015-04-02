<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\Query;

class OffreSpecialeController extends Controller
{

    /**
     * @Route("/offresspeciales", name="offresspeciales")
     */
    public function offresSpecialesAction()
    {
        $locale = $this->getRequest()->getLocale();
        $offresSpeciales = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\OffreSpeciale")
            ->createQueryBuilder('os')
            ->select('os, t')
            ->join('os.translations', 't')
            ->andWhere('t.locale = :locale')
            ->setParameter(':locale', $locale)
            ->getQuery()
            ->getResult();
        return $this->render('AppBundle:Front:OffreSpeciale/offresspeciales.html.twig', array(
            'offresSpeciales' => $offresSpeciales
        ));
    }

    /**
     * @Route("/offrespeciale/{id}", requirements={"id" = "\d+"}, name="offrespeciale")
     */
    public function offrespecialeAction($id)
    {
        $locale = $this->getRequest()->getLocale();
        
        $offrespeciale = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\OffreSpeciale")
            ->createQueryBuilder('os')
            ->select('os, t')
            ->join('os.translations', 't')
            ->where('os.id = :id')
            ->setParameter(':id', $id)
            ->andWhere('t.locale = :locale')
            ->setParameter(':locale', $locale)
            ->getQuery()
            ->getSingleResult();
        
        return $this->render('AppBundle:Front:OffreSpeciale/offrespeciale.html.twig', array(
            'offreSpeciale' => $offrespeciale
        ));
    }

    /**
     * @Route("/offrespeciale/{id}/crew", requirements={"id" = "\d+"}, name="offrespeciale_crew")
     */
    public function offreSpecialeCrewAction($id)
    {
        $locale = $this->getRequest()->getLocale();
        
        $offreSpeciale = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\OffreSpeciale")
            ->createQueryBuilder('os')
            ->select('os, s, ost, st')
            ->join('AppBundle\Entity\Skipper', 's', 'WITH', 'os.skipper = s.id')
            ->join('os.translations', 'ost')
            ->join('s.translations', 'st')
            ->where('os.id = :id')
            ->setParameter(':id', $id)
            ->andWhere('st.locale = :locale')
            ->andWhere('ost.locale = :locale')
            ->setParameter(':locale', $locale)
            ->getQuery()
            ->getResult(Query::HYDRATE_OBJECT);
        
        return $this->render('AppBundle:Front:OffreSpeciale/offrespeciale_crew.html.twig', array(
            'skipper' => isset($offreSpeciale[0]) ? $offreSpeciale[0]->getSkipper() : null
        ));
    }

    /**
     * @Route("/offrespeciale/{id}/boat", requirements={"id" = "\d+"}, name="offrespeciale_boat")
     */
    public function offreSpecialeBoatAction($id)
    {
        $locale = $this->getRequest()->getLocale();
        
        $offreSpeciale = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\OffreSpeciale")
            ->createQueryBuilder('os')
            ->select('os, b, t')
            ->join('os.bateau', 'b')
            ->join('b.translations', 't')
            ->where('os.id = :id')
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
            ->setParameter(':id', $offreSpeciale->getBateau()
            ->getId())
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
        return $this->render('AppBundle:Front:OffreSpeciale/offrespeciale_boat.html.twig', array(
            'boat' => $offreSpeciale->getBateau(),
            'prestations' => $prestation
        ));
    }

    /**
     * @Route("/offrespeciale/{id}/destination", requirements={"id" = "\d+"}, name="offrespeciale_destination")
     */
    public function offreSpecialeDestiAction($id)
    {
        $locale = $this->getRequest()->getLocale();
        
        $offreSpeciale = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\OffreSpeciale")
            ->createQueryBuilder('os')
            ->where('os.id = :id')
            ->setParameter(':id', $id)
            ->getQuery()
            ->getOneOrNullResult();
        
        return $this->render('AppBundle:Front:OffreSpeciale/offrespeciale_desti.html.twig', array(
            'offreSpeciale' => $offreSpeciale
        ));
    }

    /**
     * @Route("/offrespeciale/{id}/price", requirements={"id" = "\d+"}, name="offrespeciale_price")
     */
    public function offreSpecialePriceAction($id)
    {
        $locale = $this->getRequest()->getLocale();
        
        $offreSpeciale = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\OffreSpeciale")
            ->createQueryBuilder('os')
            ->where('os.id = :id')
            ->setParameter(':id', $id)
            ->getQuery()
            ->getOneOrNullResult();
        
        return $this->render('AppBundle:Front:OffreSpeciale/offrespeciale_price.html.twig', array(
            'offreSpeciale' => $offreSpeciale
        ));
    }

    /**
     * @Route("/offrespeciale/{id}/contact", requirements={"id" = "\d+"}, name="offrespeciale_contact")
     */
    public function offreSpecialeContactAction($id)
    {
        $locale = $this->getRequest()->getLocale();
        
        $offreSpeciale = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\OffreSpeciale")
            ->createQueryBuilder('os')
            ->where('os.id = :id')
            ->setParameter(':id', $id)
            ->getQuery()
            ->getOneOrNullResult();
        
        return $this->render('AppBundle:Front:OffreSpeciale/offrespeciale_contact.html.twig', array(
            'offreSpeciale' => $offreSpeciale
        ));
    }

    public function subMenuAction($route, $id)
    {
        $locale = $this->getRequest()->getLocale();
        
        $offrespeciale = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\OffreSpeciale")
            ->createQueryBuilder('os')
            ->select('os, t')
            ->join('os.translations', 't')
            ->where('os.id = :id')
            ->setParameter(':id', $id)
            ->andWhere('t.locale = :locale')
            ->setParameter(':locale', $locale)
            ->getQuery()
            ->getSingleResult();
        
        return $this->render('AppBundle:Front:OffreSpeciale/offrespeciale_submenu.html.twig', array(
            'offrespeciale' => $offrespeciale,
            'route' => $route
        ));
    }
}

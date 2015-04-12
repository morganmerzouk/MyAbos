<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\Query;
use AppBundle\Form\OffreSpecialeContactType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Devis;

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
    public function offreSpecialeAction($id)
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
            ->setParameter(':id', $offrespeciale->getBateau()
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
        
        return $this->render('AppBundle:Front:OffreSpeciale/offrespeciale_presentation.html.twig', array(
            'offreSpeciale' => $offrespeciale,
            'prestations' => $prestation
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
        
        return $this->render('AppBundle:Front:OffreSpeciale/offrespeciale_boat.html.twig', array(
            'boat' => $offreSpeciale->getBateau(),
            'skipper' => $offreSpeciale->getSkipper()
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
        
        $bateau = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\Bateau")
            ->createQueryBuilder('b')
            ->select('b, ipe, ipa, ipf, ipet, ipac, ipc, ipas, ipetr, ipat, ipft, ipett, ipact, ipct, ipast')
            ->leftJoin('b.inclusPrixEquipage', 'ipe')
            ->leftJoin('ipe.translations', 'ipetr', 'WITH', 'ipe.id = ipetr.translatable_id AND ipetr.locale= :locale')
            ->leftJoin('b.inclusPrixAvitaillement', 'ipa')
            ->leftJoin('ipa.translations', 'ipat', 'WITH', 'ipa.id = ipat.translatable_id AND ipat.locale= :locale')
            ->leftJoin('b.inclusPrixFraisVoyage', 'ipf')
            ->leftJoin('ipf.translations', 'ipft', 'WITH', 'ipf.id = ipft.translatable_id AND ipft.locale= :locale')
            ->leftJoin('b.inclusPrixEquipement', 'ipet')
            ->leftJoin('ipet.translations', 'ipett', 'WITH', 'ipet.id = ipett.translatable_id AND ipett.locale= :locale')
            ->leftJoin('b.inclusPrixActivite', 'ipac')
            ->leftJoin('ipac.translations', 'ipact', 'WITH', 'ipac.id = ipact.translatable_id AND ipact.locale= :locale')
            ->leftJoin('b.inclusPrixCours', 'ipc')
            ->leftJoin('ipc.translations', 'ipct', 'WITH', 'ipc.id = ipct.translatable_id AND ipct.locale= :locale')
            ->leftJoin('b.inclusPrixAutresServices', 'ipas')
            ->leftJoin('ipas.translations', 'ipast', 'WITH', 'ipas.id = ipast.translatable_id AND ipast.locale= :locale')
            ->where('b.id = :id')
            ->setParameter(":locale", $locale)
            ->setParameter(':id', $offreSpeciale->getBateau()
            ->getId())
            ->getQuery()
            ->getResult();
        $inclusPrix = array();
        
        if (isset($bateau[0]) && $bateau[0]->getInclusPrixEquipage() != null)
            array_push($inclusPrix, $bateau[0]->getInclusPrixEquipage());
        foreach ($bateau[0]->getInclusPrixAvitaillement() as $inclusPrixAvitaillement)
            array_push($inclusPrix, $inclusPrixAvitaillement);
        foreach ($bateau[0]->getInclusPrixFraisVoyage() as $inclusPrixFraisVoyage)
            array_push($inclusPrix, $inclusPrixFraisVoyage);
        foreach ($bateau[0]->getInclusPrixEquipement() as $inclusPrixEquipement)
            array_push($inclusPrix, $inclusPrixEquipement);
        foreach ($bateau[0]->getInclusPrixActivite() as $inclusPrixActivite)
            array_push($inclusPrix, $inclusPrixActivite);
        foreach ($bateau[0]->getInclusPrixCours() as $inclusPrixCours)
            array_push($inclusPrix, $inclusPrixCours);
        foreach ($bateau[0]->getInclusPrixAutresServices() as $inclusPrixAutresServices)
            array_push($inclusPrix, $inclusPrixAutresServices);
        
        return $this->render('AppBundle:Front:OffreSpeciale/offrespeciale_desti.html.twig', array(
            'offreSpeciale' => $offreSpeciale,
            'inclusPrix' => $inclusPrix
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
        
        $servicePayant = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\ServicePayant")
            ->createQueryBuilder('s')
            ->select('s, t')
            ->join('s.translations', 't')
            ->where('s.bateau = :id')
            ->orderby('s.categorie', 'ASC')
            ->setParameter(':id', $offreSpeciale->getBateau()
            ->getId())
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
        
        return $this->render('AppBundle:Front:OffreSpeciale/offrespeciale_price.html.twig', array(
            'prestations' => $prestation,
            'offreSpeciale' => $offreSpeciale,
            'servicepayant' => $servicePayant,
            'inclusprixavitaillement' => $offreSpeciale->getBateau()
                ->getInclusPrixAvitaillement(),
            'inclusprixequipage' => $offreSpeciale->getBateau()
                ->getInclusPrixEquipage(),
            'inclusprixfraisdevoyage' => $offreSpeciale->getBateau()
                ->getInclusPrixFraisVoyage(),
            'inclusprixautresservices' => $offreSpeciale->getBateau()
                ->getInclusPrixAutresServices(),
            'inclusprixequipement' => $offreSpeciale->getBateau()
                ->getInclusPrixEquipement(),
            'inclusprixactivite' => $offreSpeciale->getBateau()
                ->getInclusPrixActivite(),
            'inclusprixcours' => $offreSpeciale->getBateau()
                ->getInclusPrixCours()
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
        
        $servicePayant = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\ServicePayant")
            ->createQueryBuilder('s')
            ->select('s, t')
            ->join('s.translations', 't')
            ->where('s.bateau = :id')
            ->orderby('s.categorie', 'ASC')
            ->setParameter(':id', $offreSpeciale->getBateau()
            ->getId())
            ->getQuery()
            ->getResult();
        
        $form = $this->createForm(new OffreSpecialeContactType($this->getDoctrine()
            ->getEntityManager(), $this->getRequest()
            ->getLocale()));
        
        return $this->render('AppBundle:Front:OffreSpeciale/offrespeciale_contact.html.twig', array(
            'offreSpeciale' => $offreSpeciale,
            'servicepayant' => $servicePayant,
            'form' => $form->createView(),
            'inclusprixavitaillement' => $offreSpeciale->getBateau()
                ->getInclusPrixAvitaillement(),
            'inclusprixequipage' => $offreSpeciale->getBateau()
                ->getInclusPrixEquipage(),
            'inclusprixfraisdevoyage' => $offreSpeciale->getBateau()
                ->getInclusPrixFraisVoyage(),
            'inclusprixautresservices' => $offreSpeciale->getBateau()
                ->getInclusPrixAutresServices(),
            'inclusprixequipement' => $offreSpeciale->getBateau()
                ->getInclusPrixEquipement(),
            'inclusprixactivite' => $offreSpeciale->getBateau()
                ->getInclusPrixActivite(),
            'inclusprixcours' => $offreSpeciale->getBateau()
                ->getInclusPrixCours()
        ));
    }

    /**
     * @Route("/offrespeciale/{id}/contact/send", requirements={"id" = "\d+"}, name="offrespeciale_contact_send")
     */
    public function offreSpecialeContactSendAction($id)
    {
        $locale = $this->getRequest()->getLocale();
        
        $email = $this->getRequest()->request->get('email');
        $nom = $this->getRequest()->request->get('nom');
        $message = $this->getRequest()->request->get('message');
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
        $devis->setOffreSpecialeId($id)
            ->setNom($nom)
            ->setEmail($email)
            ->setMessage($message)
            ->setCreatedAt(new \DateTime("now"));
        if (isset($html)) {
            $devis->setServicePayant($html);
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($devis);
        $em->flush();
        return new Response("OK");
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

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
            ->andWhere('s.actif = 1')
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
            ->andWhere('s.actif = 1')
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
            ->select('c, s, t, d, t2')
            ->leftjoin('AppBundle\Entity\Skipper', 's', 'WITH', 'c.skipper = s.id AND s.actif=1')
            ->leftjoin('s.translations', 't')
            ->leftjoin('c.dateNonDisponibilite', 'd')
            ->leftjoin('c.tarifCroisiere', 't2')
            ->where('c.skipper = :id')
            ->setParameter(':id', $id)
            ->andWhere('t.locale = :locale')
            ->setParameter(':locale', $locale)
            ->getQuery()
            ->getResult(Query::HYDRATE_OBJECT);
        
        $boat = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\Bateau")
            ->createQueryBuilder('s')
            ->select('s, t')
            ->join('s.translations', 't')
            ->where('s.id = :id')
            ->setParameter(':id', $croisiere[0]->getBateau()
            ->getId())
            ->andWhere('t.locale = :locale')
            ->setParameter(':locale', $locale)
            ->getQuery()
            ->getSingleResult();
        
        $seoPage->addMeta('name', 'keyword', $skipper->getName() . ',' . $this->get('translator')
            ->trans("crew_meta_keywords"));
        $seoPage->addMeta('name', 'description', substr(strip_tags($skipper->getDescription()), 0, 255));
        
        $form = $this->createForm(new BateauDevisType($this->getDoctrine()
            ->getManager(), $this->getRequest()
            ->getLocale(), $boat->getId()));
        $form->handleRequest($this->getRequest());
        
        /**
         * * hack car bug i18n **
         */
        $inclusPrixAvitaillement = array();
        foreach ($boat->getInclusPrixAvitaillement() as $inclusPrix)
            array_push($inclusPrixAvitaillement, $inclusPrix);
        $inclusPrixAutresServices = array();
        foreach ($boat->getInclusPrixAutresServices() as $inclusPrix)
            array_push($inclusPrixAutresServices, $inclusPrix);
        $inclusPrixEquipement = array();
        foreach ($boat->getInclusPrixEquipement() as $inclusPrix)
            array_push($inclusPrixEquipement, $inclusPrix);
        $inclusPrixFraisVoyage = array();
        foreach ($boat->getInclusPrixFraisVoyage() as $inclusPrix)
            array_push($inclusPrixFraisVoyage, $inclusPrix);
        $inclusPrixEquipage = $boat->getInclusPrixEquipage()->getName();
        $inclusPrixActivite = array();
        foreach ($boat->getInclusPrixActivite() as $inclusPrix)
            array_push($inclusPrixActivite, $inclusPrix);
        $inclusPrixCours = array();
        foreach ($boat->getInclusPrixCours() as $inclusPrix)
            array_push($inclusPrixCours, $inclusPrix);
        
        return $this->render('AppBundle:Front:Skipper/skipper.html.twig', array(
            'skipper' => $skipper,
            'id' => $id,
            'offrespeciale' => isset($offreSpeciale[0]) ? $offreSpeciale[0] : null,
            'boat' => isset($croisiere[0]) ? $croisiere[0]->getBateau() : null,
            'skipper_id' => isset($croisiere[0]) ? $croisiere[0]->getSkipper()
                ->getId() : null,
            'itinerairesCroisiere' => isset($croisiere[0]) ? $croisiere[0]->getItineraireCroisiere() : null,
            'datesNonDisponibilite' => isset($croisiere[0]) ? $croisiere[0]->getDateNonDisponibilite() : null,
            'tarifs' => isset($croisiere[0]) ? $croisiere[0]->getTarifCroisiere() : null,
            'servicepayant' => isset($croisiere[0]) ? $croisiere[0]->getServicePayant() : null,
            'inclusprixavitaillement' => $inclusPrixAvitaillement,
            'inclusprixequipage' => $inclusPrixEquipage,
            'inclusprixfraisdevoyage' => $inclusPrixFraisVoyage,
            'inclusprixautresservices' => $inclusPrixAutresServices,
            'inclusprixequipement' => $inclusPrixEquipement,
            'inclusprixactivite' => $inclusPrixActivite,
            'inclusprixcours' => $inclusPrixCours,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/skipper/{id}/contact/", requirements={"id" = "\d+"}, name="skipper_contact")
     */
    public function skipperContactAction($id)
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
            ->setItineraire($this->getRequest()->request->get('itineraire'))
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
            ->where('c.skipper = :id')
            ->setParameter(':id', $id)
            ->getQuery()
            ->getOneOrNullResult();
        if ($croisiere != null) {
            $devis->setSkipper($croisiere->getSkipper())
                ->setBateau($croisiere->getBateau());
        } else {
            
            $skipper = $this->getDoctrine()
                ->getManager()
                ->getRepository("AppBundle\Entity\Skipper")
                ->createQueryBuilder('c')
                ->select('c, t')
                ->join('c.translations', 't')
                ->where('c.id = :id')
                ->setParameter(':id', $id)
                ->getQuery()
                ->getSingleResult();
            
            $devis->setSkipper($skipper->getName());
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($devis);
        $em->flush();
        
        return new Response("OK");
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

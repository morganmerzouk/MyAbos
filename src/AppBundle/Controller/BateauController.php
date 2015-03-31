<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\Query;
use AppBundle\Form\BateauDevisType;

class BateauController extends Controller
{

    /**
     * @Route("/bateaux", name="boats")
     */
    public function indexAction()
    {
        $request = $this->getRequest();
        $locale = $request->getLocale();
        
        $boats = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\Bateau")
            ->createQueryBuilder('s')
            ->select('s, t')
            ->join('s.translations', 't')
            ->andWhere('t.locale = :locale')
            ->setParameter(':locale', $locale)
            ->getQuery()
            ->getResult();
        return $this->render('AppBundle:Front:Bateau/boats.html.twig', array(
            'boats' => $boats
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
        
        return $this->render('AppBundle:Front:Bateau/boat_presentation.html.twig', array(
            'boat' => $boat
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
        
        return $this->render('AppBundle:Front:Bateau/boat_crew.html.twig', array(
            'boat' => $boat,
            'skipper' => isset($croisiere[0]) ? $croisiere[0]->getSkipper() : null
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
     * @Route("/bateau/{id}/desti", requirements={"id" = "\d+"}, name="boat_desti")
     */
    public function bateauDestiAction($id)
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
        
        return $this->render('AppBundle:Front:Bateau/boat_desti.html.twig', array(
            'boat' => $boat
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

<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\Query;

class SkipperController extends Controller
{

    /**
     * @Route("/skippers", name="skippers")
     */
    public function indexAction()
    {
        $request = $this->getRequest();
        $locale = $request->getLocale();
        
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
        $request = $this->getRequest();
        $locale = $request->getLocale();
        
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
        $request = $this->getRequest();
        $locale = $request->getLocale();
        
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
        $request = $this->getRequest();
        $locale = $request->getLocale();
        
        $destinations = null;
        
        /*
         * $this->getDoctrine()->getManager()->getRepository("AppBundle\Entity\Croisiere")
         * ->createQueryBuilder('c')
         * ->select('c, b')
         * ->join('AppBundle\Entity\Bateau', 'b', 'WITH', 'c.bateau = b.id')
         * ->join('b.translations', 't')
         * ->where('c.skipper = :id')->setParameter(':id', $id)
         * ->andWhere('t.locale = :locale')->setParameter(':locale', $locale)
         * ->getQuery()
         * ->getResult();
         */
        
        return $this->render('AppBundle:Front:Skipper/skipper_price.html.twig', array(
            'destinations' => $destinations,
            'id' => $id
        ));
    }

    /**
     * @Route("/skipper/{id}/contact", requirements={"id" = "\d+"}, name="skipper_contact")
     */
    public function skipperContactAction($id)
    {
        $request = $this->getRequest();
        $locale = $request->getLocale();
        
        $destinations = null;
        
        /*
         * $this->getDoctrine()->getManager()->getRepository("AppBundle\Entity\Croisiere")
         * ->createQueryBuilder('c')
         * ->select('c, b')
         * ->join('AppBundle\Entity\Bateau', 'b', 'WITH', 'c.bateau = b.id')
         * ->join('b.translations', 't')
         * ->where('c.skipper = :id')->setParameter(':id', $id)
         * ->andWhere('t.locale = :locale')->setParameter(':locale', $locale)
         * ->getQuery()
         * ->getResult();
         */
        
        return $this->render('AppBundle:Front:Skipper/skipper_contact.html.twig', array(
            'destinations' => $destinations,
            'id' => $id
        ));
    }

    public function subMenuAction($route, $id)
    {
        $request = $this->getRequest();
        $locale = $request->getLocale();
        
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

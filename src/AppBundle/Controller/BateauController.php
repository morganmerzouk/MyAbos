<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\Query;
class BateauController extends Controller
{
    /**
     * @Route("/bateaux", name="boats")
     */
    public function indexAction()
    {        
        $request = $this->getRequest();
        $locale = $request->getLocale();
        
        $boats = $this->getDoctrine()->getManager()->getRepository("AppBundle\Entity\Bateau")
        ->createQueryBuilder('s')
        ->select('s, t')
        ->join('s.translations', 't')
        ->andWhere('s.published = true')
        ->andWhere('t.locale = :locale')->setParameter(':locale', $locale)
        ->getQuery()
        ->getResult();
        return $this->render('AppBundle:Front:Bateau/boats.html.twig',array('boats'=> $boats));
    }
    
    /**
     * @Route("/bateau/{id}", requirements={"id" = "\d+"}, name="boat")
     */
    public function bateauAction($id)
    {
        $request = $this->getRequest();
        $locale = $request->getLocale();
        
        $boat = $this->getDoctrine()->getManager()->getRepository("AppBundle\Entity\Bateau")
        ->createQueryBuilder('s')
        ->select('s, t')
        ->join('s.translations', 't')
        ->where('s.id = :id')->setParameter(':id', $id)
        ->andWhere('s.published = true')
        ->andWhere('t.locale = :locale')->setParameter(':locale', $locale)
        ->getQuery()
        ->getSingleResult();
        
        return $this->render('AppBundle:Front:Bateau/boat.html.twig',array('boat'=> $boat));
    }
   
    /**
     * @Route("/bateau/{id}/details", requirements={"id" = "\d+"}, name="boat_details")
     */
    public function bateauDetailAction($id)
    {
        $request = $this->getRequest();
        $locale = $request->getLocale();
        
        $boat = $this->getDoctrine()->getManager()->getRepository("AppBundle\Entity\Bateau")
        ->createQueryBuilder('s')
        ->select('s, t')
        ->join('s.translations', 't')
        ->where('s.id = :id')->setParameter(':id', $id)
        ->andWhere('s.published = true')
        ->andWhere('t.locale = :locale')->setParameter(':locale', $locale)
        ->getQuery()
        ->getSingleResult();
        
        return $this->render('AppBundle:Front:Bateau/boat_details.html.twig',array('boat'=> $boat));
    }
    
    /**
     * @Route("/bateau/{id}/crew", requirements={"id" = "\d+"}, name="boat_crew")
     */
    public function bateauCrewAction($id)
    {
        $request = $this->getRequest();
        $locale = $request->getLocale();
        
        $boat = $this->getDoctrine()->getManager()->getRepository("AppBundle\Entity\Bateau")
        ->createQueryBuilder('s')
        ->select('s, t')
        ->join('s.translations', 't')
        ->where('s.id = :id')->setParameter(':id', $id)
        ->andWhere('s.published = true')
        ->andWhere('t.locale = :locale')->setParameter(':locale', $locale)
        ->getQuery()
        ->getSingleResult();
        
        return $this->render('AppBundle:Front:Bateau/boat_crew.html.twig',array('boat'=> $boat));
    }
    
        /**
     * @Route("/bateau/{id}/available", requirements={"id" = "\d+"}, name="boat_available")
     */
    public function bateauAvailableAction($id)
    {
        $request = $this->getRequest();
        $locale = $request->getLocale();
        
        $croisieres = $this->getDoctrine()->getManager()->getRepository("AppBundle\Entity\Croisiere")
        ->createQueryBuilder('c')
        ->select('c,d')
        ->join('c.bateau', 'b')
        ->join('c.dateNonDisponibilite', 'd')
        ->where('b.id = :id')->setParameter(':id', $id)
        ->getQuery()
        ->getResult(Query::HYDRATE_OBJECT);
        return $this->render('AppBundle:Front:Bateau/boat_available.html.twig',array('datesNonDisponibilite'=> $croisieres[0]->getDateNonDisponibilite()));
    }
    
    /**
     * @Route("/bateau/{id}/desti", requirements={"id" = "\d+"}, name="boat_desti")
     */
    public function bateauDestiAction($id)
    {
        $request = $this->getRequest();
        $locale = $request->getLocale();
        
        $boat = $this->getDoctrine()->getManager()->getRepository("AppBundle\Entity\Bateau")
        ->createQueryBuilder('s')
        ->select('s, t')
        ->join('s.translations', 't')
        ->where('s.id = :id')->setParameter(':id', $id)
        ->andWhere('s.published = true')
        ->andWhere('t.locale = :locale')->setParameter(':locale', $locale)
        ->getQuery()
        ->getSingleResult();
        
        return $this->render('AppBundle:Front:Bateau/boat_desti.html.twig',array('boat'=> $boat));
    }
    
    /**
     * @Route("/bateau/{id}/price", requirements={"id" = "\d+"}, name="boat_price")
     */
    public function bateauPriceAction($id)
    {
        $request = $this->getRequest();
        $locale = $request->getLocale();
        
        $boat = $this->getDoctrine()->getManager()->getRepository("AppBundle\Entity\Bateau")
        ->createQueryBuilder('s')
        ->select('s, t')
        ->join('s.translations', 't')
        ->where('s.id = :id')->setParameter(':id', $id)
        ->andWhere('s.published = true')
        ->andWhere('t.locale = :locale')->setParameter(':locale', $locale)
        ->getQuery()
        ->getSingleResult();
        
        return $this->render('AppBundle:Front:Bateau/boat_price.html.twig',array('boat'=> $boat));
    }
    
    /**
     * @Route("/bateau/{id}/contact", requirements={"id" = "\d+"}, name="boat_contact")
     */
    public function bateauContactAction($id)
    {
        $request = $this->getRequest();
        $locale = $request->getLocale();
        
        $boat = $this->getDoctrine()->getManager()->getRepository("AppBundle\Entity\Bateau")
        ->createQueryBuilder('s')
        ->select('s, t')
        ->join('s.translations', 't')
        ->where('s.id = :id')->setParameter(':id', $id)
        ->andWhere('s.published = true')
        ->andWhere('t.locale = :locale')->setParameter(':locale', $locale)
        ->getQuery()
        ->getSingleResult();
        
        return $this->render('AppBundle:Front:Bateau/boat_contact.html.twig',array('boat'=> $boat));
    }
      
    public function subMenuAction($route, $id)
    {  
        $request = $this->getRequest();
        $locale = $request->getLocale();
        
        $boat = $this->getDoctrine()->getManager()->getRepository("AppBundle\Entity\Bateau")
        ->createQueryBuilder('s')
        ->select('s, t')
        ->join('s.translations', 't')
        ->where('s.id = :id')->setParameter(':id', $id)
        ->andWhere('s.published = true')
        ->andWhere('t.locale = :locale')->setParameter(':locale', $locale)
        ->getQuery()
        ->getSingleResult();
        
        return $this->render('AppBundle:Front:Bateau/boat_submenu.html.twig',array('boat'=> $boat, 'route'=> $route));
    }
}

<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SkipperController extends Controller
{
    /**
     * @Route("/skippers", name="skippers")
     */
    public function indexAction()
    {        
        $request = $this->getRequest();
        $locale = $request->getLocale();
        
        $skippers = $this->getDoctrine()->getManager()->getRepository("AppBundle\Entity\Skipper")
        ->createQueryBuilder('s')
        ->select('s, t')
        ->join('s.translations', 't')
        ->andWhere('s.published = true')
        ->andWhere('t.locale = :locale')->setParameter(':locale', $locale)
        ->getQuery()
        ->getResult();
        return $this->render('AppBundle:Front:Skipper/skippers.html.twig',array('skippers'=> $skippers));
    }
    
    /**
     * @Route("/skipper/{id}", requirements={"id" = "\d+"}, name="skipper")
     */
    public function skipperAction($id)
    {
        $request = $this->getRequest();
        $locale = $request->getLocale();
        
        $skipper = $this->getDoctrine()->getManager()->getRepository("AppBundle\Entity\Skipper")
        ->createQueryBuilder('s')
        ->select('s, t')
        ->join('s.translations', 't')
        ->where('s.id = :id')->setParameter(':id', $id)
        ->andWhere('s.published = true')
        ->andWhere('t.locale = :locale')->setParameter(':locale', $locale)
        ->getQuery()
        ->getSingleResult();
        
        return $this->render('AppBundle:Front:Skipper/skipper_presentation.html.twig',array('skipper'=> $skipper, 'id' => $id));
    }
    
    /**
     * @Route("/skipper/{id}/bateaux", requirements={"id" = "\d+"}, name="skipper_bateaux")
     */
    public function skipperFlottesAction($id)
    {
        $request = $this->getRequest();
        $locale = $request->getLocale();
        
        $bateaux = $this->getDoctrine()->getManager()->getRepository("AppBundle\Entity\Croisiere")
        ->createQueryBuilder('c')
        ->select('c, b')
        ->join('AppBundle\Entity\Bateau', 'b', 'WITH', 'c.bateau = b.id')
        ->join('b.translations', 't')
        ->where('c.skipper = :id')->setParameter(':id', $id)
        ->andWhere('t.locale = :locale')->setParameter(':locale', $locale)
        ->getQuery()
        ->getResult();
        
        return $this->render('AppBundle:Front:Skipper/skipper_bateau.html.twig',array('bateaux'=> $bateaux, 'id' => $id));
    }
    
    /**
     * @Route("/skipper/{id}/destination", requirements={"id" = "\d+"}, name="skipper_desti")
     */
    public function skipperDestiAction($id)
    {
        $request = $this->getRequest();
        $locale = $request->getLocale();
        
        $destinations = null;
        
        /*$this->getDoctrine()->getManager()->getRepository("AppBundle\Entity\Croisiere")
        ->createQueryBuilder('c')
        ->select('c, b')
        ->join('AppBundle\Entity\Bateau', 'b', 'WITH', 'c.bateau = b.id')
        ->join('b.translations', 't')
        ->where('c.skipper = :id')->setParameter(':id', $id)
        ->andWhere('t.locale = :locale')->setParameter(':locale', $locale)
        ->getQuery()
        ->getResult();*/
        
        return $this->render('AppBundle:Front:Skipper/skipper_desti.html.twig',array('destinations'=> $destinations, 'id' => $id));
    }
    
        /**
     * @Route("/skipper/{id}/disponibilite", requirements={"id" = "\d+"}, name="skipper_available")
     */
    public function skipperAvailableAction($id)
    {
        $request = $this->getRequest();
        $locale = $request->getLocale();
        
        $destinations = null;
        
        /*$this->getDoctrine()->getManager()->getRepository("AppBundle\Entity\Croisiere")
        ->createQueryBuilder('c')
        ->select('c, b')
        ->join('AppBundle\Entity\Bateau', 'b', 'WITH', 'c.bateau = b.id')
        ->join('b.translations', 't')
        ->where('c.skipper = :id')->setParameter(':id', $id)
        ->andWhere('t.locale = :locale')->setParameter(':locale', $locale)
        ->getQuery()
        ->getResult();*/
        
        return $this->render('AppBundle:Front:Skipper/skipper_available.html.twig',array('destinations'=> $destinations, 'id' => $id));
    }
    
        /**
     * @Route("/skipper/{id}/price", requirements={"id" = "\d+"}, name="skipper_price")
     */
    public function skipperPriceAction($id)
    {
        $request = $this->getRequest();
        $locale = $request->getLocale();
        
        $destinations = null;
        
        /*$this->getDoctrine()->getManager()->getRepository("AppBundle\Entity\Croisiere")
        ->createQueryBuilder('c')
        ->select('c, b')
        ->join('AppBundle\Entity\Bateau', 'b', 'WITH', 'c.bateau = b.id')
        ->join('b.translations', 't')
        ->where('c.skipper = :id')->setParameter(':id', $id)
        ->andWhere('t.locale = :locale')->setParameter(':locale', $locale)
        ->getQuery()
        ->getResult();*/
        
        return $this->render('AppBundle:Front:Skipper/skipper_price.html.twig',array('destinations'=> $destinations, 'id' => $id));
    }    
    
    /**
     * @Route("/skipper/{id}/contact", requirements={"id" = "\d+"}, name="skipper_contact")
     */
    public function skipperContactAction($id)
    {
        $request = $this->getRequest();
        $locale = $request->getLocale();
        
        $destinations = null;
        
        /*$this->getDoctrine()->getManager()->getRepository("AppBundle\Entity\Croisiere")
        ->createQueryBuilder('c')
        ->select('c, b')
        ->join('AppBundle\Entity\Bateau', 'b', 'WITH', 'c.bateau = b.id')
        ->join('b.translations', 't')
        ->where('c.skipper = :id')->setParameter(':id', $id)
        ->andWhere('t.locale = :locale')->setParameter(':locale', $locale)
        ->getQuery()
        ->getResult();*/
        
        return $this->render('AppBundle:Front:Skipper/skipper_contact.html.twig',array('destinations'=> $destinations, 'id' => $id));
    }
    
    public function subMenuAction($route, $id)
    {  
        $request = $this->getRequest();
        $locale = $request->getLocale();
        
        $skipper = $this->getDoctrine()->getManager()->getRepository("AppBundle\Entity\Skipper")
        ->createQueryBuilder('s')
        ->select('s, t')
        ->join('s.translations', 't')
        ->where('s.id = :id')->setParameter(':id', $id)
        ->andWhere('s.published = true')
        ->andWhere('t.locale = :locale')->setParameter(':locale', $locale)
        ->getQuery()
        ->getSingleResult();
        
        return $this->render('AppBundle:Front:Skipper/skipper_submenu.html.twig',array('skipper'=> $skipper, 'route'=> $route));
    }
}

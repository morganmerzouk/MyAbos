<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BateauController extends Controller
{
    /**
     * @Route("/bateaux", name="bateaux")
     */
    public function indexAction()
    {        
        $request = $this->getRequest();
        $locale = $request->getLocale();
        
        $bateaux = $this->getDoctrine()->getManager()->getRepository("AppBundle\Entity\Bateau")
        ->createQueryBuilder('s')
        ->select('s, t')
        ->join('s.translations', 't')
        ->andWhere('s.published = true')
        ->andWhere('t.locale = :locale')->setParameter(':locale', $locale)
        ->getQuery()
        ->getResult();
        return $this->render('AppBundle:Front:bateaux.html.twig',array('bateaux'=> $bateaux));
    }
    
    /**
     * @Route("/bateau/{id}", requirements={"id" = "\d+"}, name="bateau")
     */
    public function bateauAction($id)
    {
        $request = $this->getRequest();
        $locale = $request->getLocale();
        
        $bateau = $this->getDoctrine()->getManager()->getRepository("AppBundle\Entity\Bateau")
        ->createQueryBuilder('s')
        ->select('s, t')
        ->join('s.translations', 't')
        ->where('s.id = :id')->setParameter(':id', $id)
        ->andWhere('s.published = true')
        ->andWhere('t.locale = :locale')->setParameter(':locale', $locale)
        ->getQuery()
        ->getSingleResult();
        
        return $this->render('AppBundle:Front:bateau.html.twig',array('bateau'=> $bateau));
    }
}
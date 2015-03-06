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
        $skippers = $this->getDoctrine()->getManager()->getRepository("AppBundle\Entity\Skipper")
        ->createQueryBuilder('s')
        ->select('s, t')
        ->join('s.translations', 't')
        ->andWhere('s.published = true')
        ->andWhere('t.locale = :locale')->setParameter(':locale', 'fr')
        ->getQuery()
        ->getResult();
        return $this->render('AppBundle:Front:skippers.html.twig',array('skippers'=> $skippers));
    }
    
    /**
     * @Route("/skipper/{id}", requirements={"id" = "\d+"}, name="skipper")
     */
    public function skipperAction($id)
    {
        $skipper = $this->getDoctrine()->getManager()->getRepository("AppBundle\Entity\Skipper")
        ->createQueryBuilder('s')
        ->select('s, t')
        ->join('s.translations', 't')
        ->where('s.id = :id')->setParameter(':id', $id)
        ->andWhere('s.published = true')
        ->andWhere('t.locale = :locale')->setParameter(':locale', 'fr')
        ->getQuery()
        ->getSingleResult();
        
        return $this->render('AppBundle:Front:skipper.html.twig',array('skipper'=> $skipper));
    }
}

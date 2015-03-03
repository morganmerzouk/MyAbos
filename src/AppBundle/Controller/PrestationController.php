<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PrestationController extends Controller
{
    /**
     * @Route("/prestations", name="prestations")
     */
    public function indexAction()
    {        
        $prestations = $this->getDoctrine()->getManager()->getRepository("AppBundle\Entity\Prestation")
                   ->findBy(array('published'=> true));
        return $this->render('AppBundle:Front:prestations.html.twig',array('prestations'=>$prestations));
    }
}

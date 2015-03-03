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
        return $this->render('AppBundle:Front:bateaux.html.twig');
    }
}

<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LienController extends Controller
{
    /**
     * @Route("/liens", name="liens")
     */
    public function indexAction()
    {        
        return $this->render('AppBundle:Front:liens.html.twig');
    }
}

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
        return $this->render('AppBundle:Front:skippers.html.twig');
    }
}

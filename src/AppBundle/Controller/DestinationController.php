<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DestinationController extends Controller
{
    /**
     * @Route("/destinations", name="destinations")
     */
    public function indexAction()
    {        
        return $this->render('AppBundle:Front:destinations.html.twig');
    }
}

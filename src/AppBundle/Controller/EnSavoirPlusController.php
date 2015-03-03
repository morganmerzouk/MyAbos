<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EnSavoirPlusController extends Controller
{
    /**
     * @Route("/ensavoirplus", name="ensavoirplus")
     */
    public function indexAction()
    {        
        return $this->render('AppBundle:Front:ensavoirplus.html.twig');
    }
}

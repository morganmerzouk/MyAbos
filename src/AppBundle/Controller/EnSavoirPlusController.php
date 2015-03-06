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
        return $this->render('AppBundle:Front:ensavoirplus/ensavoirplus.html.twig');
    }
    
    /**
     * @Route("/ensavoirplus/croisiere", name="ensavoirplus_croisiere")
     */
    public function croisiereAction()
    {
        return $this->render('AppBundle:Front:ensavoirplus/ensavoirplus_croisiere.html.twig');
    }
    
    /**
     * @Route("/ensavoirplus/reseau", name="ensavoirplus_reseau")
     */
    public function reseauAction()
    {
        return $this->render('AppBundle:Front:ensavoirplus/ensavoirplus_reseau.html.twig');
    }

    /**
     * @Route("/ensavoirplus/meteo", name="ensavoirplus_meteo")
     */
    public function meteoAction()
    {
        return $this->render('AppBundle:Front:ensavoirplus/ensavoirplus_meteo.html.twig');
    }
}

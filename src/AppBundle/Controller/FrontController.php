<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\SearchHomeType;

class FrontController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {        
        $form = $this->createForm(new SearchHomeType());
        return $this->render('AppBundle:Front:home.html.twig', array('form' => $form->createView()));
    }
}

<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\SearchHeaderType;

class FrontController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {        
        $request = $this->getRequest();
        
        $locale = $request->getLocale();
        
        return $this->render('AppBundle:Front:home.html.twig');
    }
    
    public function searchHeaderAction()
    {  
        $form = $this->createForm(new SearchHeaderType());
        return $this->render('AppBundle:Front:form/search_header.html.twig', array('form'=>$form->createView()));
    }
}

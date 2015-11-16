<?php
namespace App\BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{

    public function indexAction()
    {
        return $this->render('AppBackOfficeBundle:Default:index.html.twig');
    }
}

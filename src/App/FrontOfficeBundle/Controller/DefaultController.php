<?php
namespace App\FrontOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{

    public function indexAction()
    {
        return $this->render('AppFrontOfficeBundle:Profile:show.html.twig');
    }
}
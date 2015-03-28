<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class OffreSpecialeController extends Controller
{

    /**
     * @Route("/offresspeciales", name="offresspeciales")
     */
    public function indexAction()
    {
        return $this->render('AppBundle:Front:offresspeciales.html.twig');
    }
}

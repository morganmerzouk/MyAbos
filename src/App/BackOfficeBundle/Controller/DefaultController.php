<?php
namespace App\BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\MainBundle\Entity\Contract;

class DefaultController extends Controller
{

    public function indexAction()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');
        
        $em = $this->getDoctrine()->getEntityManager();
        
        $contracts = $em->getRepository("AppMainBundle:Contract")->findBy(array(
            "status" => Contract::STATUS_RESILIATING
        ));
        
        return $this->render('AppBackOfficeBundle:Default:index.html.twig', array(
            "contracts" => $contracts
        ));
    }
}

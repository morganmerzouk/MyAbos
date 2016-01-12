<?php
namespace App\FrontOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\MainBundle\Entity\Contract;

class AlertController extends Controller
{

    public function indexAction(Request $request)
    {
        $user = $this->get('security.token_storage')
            ->getToken()
            ->getUser();
        $em = $this->getDoctrine()->getManager();
        $contracts = $em->getRepository("AppMainBundle:Contract")
            ->createQueryBuilder("c")
            ->select("c")
            ->andWhere("c.user = :user")
            ->setParameter(":user", $user)
            ->getQuery()
            ->getResult();
        
        return $this->render('AppFrontOfficeBundle:Alert:index.html.twig', array(
            'contracts' => $contracts,
            'contractsChatel' => $contracts
        ));
    }
}
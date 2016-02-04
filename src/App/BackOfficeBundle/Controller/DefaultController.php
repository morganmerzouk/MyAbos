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
            "status" => array(
                Contract::STATUS_RESILIATING,
                Contract::STATUS_RESILIATION_SENT,
                Contract::STATUS_RESILIATED
            )
        ));
        
        return $this->render('AppBackOfficeBundle:Default:index.html.twig', array(
            "contracts" => $contracts
        ));
    }

    public function resiliatingAction($id)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');
        
        $em = $this->getDoctrine()->getEntityManager();
        
        $contract = $em->getRepository("AppMainBundle:Contract")->findOneById($id);
        
        $contract->setStatus(Contract::STATUS_RESILIATION_SENT);
        $em->persist($contract);
        $em->flush();
        
        $contracts = $em->getRepository("AppMainBundle:Contract")->findBy(array(
            "status" => array(
                Contract::STATUS_RESILIATING,
                Contract::STATUS_RESILIATION_SENT,
                Contract::STATUS_RESILIATED
            )
        ));
        
        return $this->render('AppBackOfficeBundle:Default:index.html.twig', array(
            "contracts" => $contracts
        ));
    }

    public function resiliatedAction($id)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');
        
        $em = $this->getDoctrine()->getEntityManager();
        
        $contract = $em->getRepository("AppMainBundle:Contract")->findOneById($id);
        
        $contract->setStatus(Contract::STATUS_RESILIATED);
        $em->persist($contract);
        $em->flush();
        
        $contracts = $em->getRepository("AppMainBundle:Contract")->findBy(array(
            "status" => array(
                Contract::STATUS_RESILIATING,
                Contract::STATUS_RESILIATION_SENT,
                Contract::STATUS_RESILIATED
            )
        ));
        
        return $this->render('AppBackOfficeBundle:Default:index.html.twig', array(
            "contracts" => $contracts
        ));
    }
}

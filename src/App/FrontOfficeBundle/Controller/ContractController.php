<?php
namespace App\FrontOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\FrontOfficeBundle\Form\Type\ContractType;
use App\MainBundle\Entity\Contract;

class ContractController extends Controller
{

    public function indexAction(Request $request)
    {
        $contract = new Contract();
        $form = $this->createForm(new ContractType(), $contract);
        
        $form->handleRequest($request);
        
        $em = $this->getDoctrine()->getManager();
        if ($form->isValid()) {
            $em->persist($contract);
            $em->flush();
            
            return $this->redirectToRoute('task_success');
        }
        
        return $this->render('AppFrontOfficeBundle:Contract:add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function addContractAction()
    {
        $contract = new Contract();
        $form = $this->createForm(new ContratType(), $contract);
        return $this->render('AppFrontOfficeBundle:Contract:add.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
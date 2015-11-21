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
        return $this->redirectToRoute('app_front_office_contract_list');
    }

    public function addAction(Request $request)
    {
        $contract = new Contract();
        $form = $this->createForm(new ContractType(), $contract);
        
        $form->handleRequest($request);
        
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository("AppMainBundle:Category")->findBy(array(
            "actif" => "1"
        ));
        if ($form->isValid()) {
            
            $user = $this->get('security.token_storage')
                ->getToken()
                ->getUser();
            $contract->setUser($user);
            
            $em->persist($contract);
            $em->flush();
            
            return $this->redirectToRoute('app_front_office_contract_list');
        }
        
        return $this->render('AppFrontOfficeBundle:Contract:add.html.twig', array(
            'form' => $form->createView(),
            'categories' => $categories
        ));
    }

    public function editAction(Request $request, $id)
    {
        $user = $this->get('security.token_storage')
            ->getToken()
            ->getUser();
        $em = $this->getDoctrine()->getManager();
        $contract = $em->getRepository("AppMainBundle:Contract")->findOneBy(array(
            "user" => $user,
            "id" => $id
        ));
        $form = $this->createForm(new ContractType(), $contract);
        
        $form->handleRequest($request);
        if ($form->isValid()) {
            
            $user = $this->get('security.token_storage')
                ->getToken()
                ->getUser();
            $contract->setUser($user);
            
            $em->persist($contract);
            $em->flush();
            
            return $this->redirectToRoute('app_front_office_contract_list');
        }
        return $this->render('AppFrontOfficeBundle:Contract:edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function deleteAction($id)
    {
        $user = $this->get('security.token_storage')
            ->getToken()
            ->getUser();
        $em = $this->getDoctrine()->getManager();
        $contract = $em->getRepository("AppMainBundle:Contract")->findBy(array(
            "user_id" => $user->getId(),
            "id" => $id
        ));
        
        if (! $contract) {
            throw $this->createNotFoundException('No contract found for id ' . $id);
        }
        
        $em->remove($contract);
        $em->flush();
        
        return $this->redirectToRoute('app_front_office_contract_list');
    }

    public function listAction()
    {
        $user = $this->get('security.token_storage')
            ->getToken()
            ->getUser();
        $em = $this->getDoctrine()->getManager();
        
        $contracts = $em->getRepository("AppMainBundle:Contract")->findBy(array(
            "user" => $user->getId()
        ));
        
        return $this->render('AppFrontOfficeBundle:Contract:list.html.twig', array(
            'contracts' => $contracts
        ));
    }
}
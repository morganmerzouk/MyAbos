<?php
namespace App\FrontOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\FrontOfficeBundle\Form\Type\ContractType;
use App\MainBundle\Entity\Contract;
use App\MainBundle\Entity\Category;

class ResiliationController extends Controller
{

    public function indexAction(Request $request)
    {
        $user = $this->get('security.token_storage')
            ->getToken()
            ->getUser();
        $em = $this->getDoctrine()->getManager();
        $contracts = $em->getRepository("AppMainBundle:Contract")->findBy(array(
            "user" => $user
        ), array(
            "category" => "ASC"
        ));
        
        $categories = array();
        $currentCategory = "";
        foreach ($contracts as $contract) {
            if ($contract->getCategory()->getName() != $currentCategory) {
                $categories[] = array(
                    "id" => $contract->getCategory()->getId(),
                    "name" => $contract->getCategory()->getName(),
                    "amountByYear" => 0
                );
            }
            $categories[count($categories) - 1]["amountByYear"] += $contract->getAmountByYear();
            $currentCategory = $contract->getCategory()->getName();
        }
        
        return $this->render('AppFrontOfficeBundle:Resiliation:list.html.twig', array(
            'contracts' => $contracts,
            'categories' => $categories
        ));
    }

    public function choixFormuleAction(Request $request)
    {
        return $this->render('AppFrontOfficeBundle:Resiliation:choixFormule.html.twig', array()

        );
    }
}
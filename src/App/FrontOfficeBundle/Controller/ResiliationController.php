<?php
namespace App\FrontOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\FrontOfficeBundle\Form\Type\ContractType;
use App\FrontOfficeBundle\Form\Type\ResiliationType;
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

    public function previewAction(Request $request, $id)
    {
        $user = $this->get('security.token_storage')
            ->getToken()
            ->getUser();
        $em = $this->getDoctrine()->getManager();
        $contract = $em->getRepository("AppMainBundle:Contract")->findOneBy(array(
            "user" => $user,
            "id" => $id
        ));
        $causeResiliation = $em->getRepository("AppMainBundle:CauseResiliation")->findBy(array(
            "category" => $contract->getCategory()
        ));
        
        $form = $this->createForm(new ResiliationType($em, $contract->getCategory()
            ->getId(), $id));
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            $data = $form->getData();
            $contract->setCauseResiliation($data->getCauseResiliation())
                ->setStatus(Contract::STATUS_RESILIATING)
                ->setResiliationDate(new \DateTime());
            $em->persist($contract);
            $em->flush();
            $this->addFlash('notice', "La résiliation de votre contract " . $contract->getProvider() . " a été enregistré avec succès, nous vous tiendrons par email du statut de celle-ci");
            return $this->redirectToRoute("app_front_office_contract_list");
        }
        
        return $this->render('AppFrontOfficeBundle:Resiliation:preview.html.twig', array(
            "contract" => $contract,
            "causeResiliations" => $causeResiliation,
            "form" => $form->createView()
        ));
    }

    public function choixFormuleAction(Request $request)
    {
        return $this->render('AppFrontOfficeBundle:Resiliation:choixFormule.html.twig', array());
    }

    public function pdfAction(Request $request, $id, $idCauseResiliation)
    {
        /* Empecher un utilisateur qui a payé pour un contrat d'accéder aux autres en modifiant l'url */
        $em = $this->getDoctrine()->getManager();
        $causeResiliation = $em->getRepository("AppMainBundle:CauseResiliation")->findOneBy(array(
            "id" => $idCauseResiliation
        ));
        
        $user = $this->get('security.token_storage')
            ->getToken()
            ->getUser();
        $em = $this->getDoctrine()->getManager();
        $contract = $em->getRepository("AppMainBundle:Contract")->findOneBy(array(
            "user" => $user,
            "id" => $id
        ));
        $html = utf8_decode($this->renderView('AppFrontOfficeBundle:Resiliation:pdf.html.twig', array(
            'contract' => $contract,
            'causeResiliation' => $causeResiliation
        )));
        return new Response($this->get('knp_snappy.pdf')->getOutputFromHtml($html), 200, array(
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'filename="test.pdf"'
        ));
    }
}
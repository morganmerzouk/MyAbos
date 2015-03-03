<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class CroisiereController extends Controller {
    
    /**
     * @Route("/croisieres", name="croisieres")
     */
    public function indexAction()
    {        
        return $this->render('AppBundle:Front:croisieres.html.twig');
    }
    
    public function cloneAction()
    {
        $id = $this->get('request')->get($this->admin->getIdParameter());

        $object = $this->admin->getObject($id);

        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }

        $clonedObject = clone $object;
        $this->admin->create($clonedObject);
        
        $em = $this->getDoctrine()->getManager();
        $croisieresTranslations = $em->getRepository("AppBundle\Entity\CroisiereTranslation")->findBy(array('translatable_id'=>$id));
        foreach($croisieresTranslations as $croisiereTranslation) {
            $newCroisiereTranslation = clone $croisiereTranslation;
            $newCroisiereTranslation->setTranslatable($clonedObject);
            $newCroisiereTranslation->setTranslatableId($clonedObject->getId());
            $newCroisiereTranslation->setName($croisiereTranslation->getName(). '(Clone)');
            $em->persist($newCroisiereTranslation);
            $em->flush();
        }
        
        $this->addFlash('sonata_flash_success', 'Cloned successfully');

        return new RedirectResponse($this->admin->generateUrl('list'));
    }

    public function getServicePayantAction($id) {
        if(!$id)
            return;
        
        $servicesPayant=$this->getDoctrine()->getManager()->getRepository("AppBundle\Entity\ServicePayant")
                            ->findBy(array('bateau'=>$id));
        
        $html = "";
        foreach($servicesPayant as $servicePayant){
            $html .="<option value=".$servicePayant->getId().">".$servicePayant->getName()."</option>";
        }
        
        return new Response($html);
    }
}

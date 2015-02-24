<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CRUDController extends Controller {
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
}

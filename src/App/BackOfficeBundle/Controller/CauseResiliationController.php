<?php
namespace App\BackOfficeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\MainBundle\Entity\CauseResiliation;
use App\BackOfficeBundle\Form\CauseResiliationType;

/**
 * CauseResiliation controller.
 */
class CauseResiliationController extends Controller
{

    /**
     * Lists all CauseResiliation entities.
     */
    public function indexAction()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');
        $em = $this->getDoctrine()->getManager();
        
        $entities = $em->getRepository('AppMainBundle:CauseResiliation')->findAll();
        
        return $this->render('AppBackOfficeBundle:CauseResiliation:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Creates a new CauseResiliation entity.
     */
    public function createAction(Request $request)
    {
        $entity = new CauseResiliation();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            
            return $this->redirect($this->generateUrl('cause_resiliation_show', array(
                'id' => $entity->getId()
            )));
        }
        
        return $this->render('AppBackOfficeBundle:CauseResiliation:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView()
        ));
    }

    /**
     * Creates a form to create a CauseResiliation entity.
     *
     * @param CauseResiliation $entity
     *            The entity
     *            
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(CauseResiliation $entity)
    {
        $form = $this->createForm(new CauseResiliationType(), $entity, array(
            'action' => $this->generateUrl('cause_resiliation_create'),
            'method' => 'POST'
        ));
        
        $form->add('submit', 'submit', array(
            'label' => 'Create'
        ));
        
        return $form;
    }

    /**
     * Displays a form to create a new CauseResiliation entity.
     */
    public function newAction()
    {
        $entity = new CauseResiliation();
        $form = $this->createCreateForm($entity);
        
        return $this->render('AppBackOfficeBundle:CauseResiliation:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView()
        ));
    }

    /**
     * Finds and displays a CauseResiliation entity.
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $entity = $em->getRepository('AppMainBundle:CauseResiliation')->find($id);
        
        if (! $entity) {
            throw $this->createNotFoundException('Unable to find CauseResiliation entity.');
        }
        
        $deleteForm = $this->createDeleteForm($id);
        
        return $this->render('AppBackOfficeBundle:CauseResiliation:show.html.twig', array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView()
        ));
    }

    /**
     * Displays a form to edit an existing CauseResiliation entity.
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $entity = $em->getRepository('AppMainBundle:CauseResiliation')->find($id);
        
        if (! $entity) {
            throw $this->createNotFoundException('Unable to find CauseResiliation entity.');
        }
        
        $editForm = $this->createEditForm($entity);
        
        return $this->render('AppBackOfficeBundle:CauseResiliation:edit.html.twig', array(
            'entity' => $entity,
            'form' => $editForm->createView()
        ));
    }

    /**
     * Creates a form to edit a CauseResiliation entity.
     *
     * @param CauseResiliation $entity
     *            The entity
     *            
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(CauseResiliation $entity)
    {
        $form = $this->createForm(new CauseResiliationType(), $entity, array(
            'action' => $this->generateUrl('cause_resiliation_update', array(
                'id' => $entity->getId()
            ))
        ));
        
        $form->add('submit', 'submit', array(
            'label' => 'Update'
        ));
        
        return $form;
    }

    /**
     * Edits an existing CauseResiliation entity.
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $entity = $em->getRepository('AppMainBundle:CauseResiliation')->find($id);
        
        if (! $entity) {
            throw $this->createNotFoundException('Unable to find CauseResiliation entity.');
        }
        
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);
        if ($editForm->isValid()) {
            $em->flush();
            return $this->redirect($this->generateUrl('cause_resiliation'));
        }
        
        return $this->render('AppBackOfficeBundle:CauseResiliation:edit.html.twig', array(
            'entity' => $entity,
            'form' => $editForm->createView()
        ));
    }

    /**
     * Deletes a CauseResiliation entity.
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppMainBundle:CauseResiliation')->find($id);
        
        if (! $entity) {
            throw $this->createNotFoundException('Unable to find CauseResiliation entity.');
        }
        
        $em->remove($entity);
        $em->flush();
        
        return $this->redirect($this->generateUrl('cause_resiliation'));
    }

    /**
     * Creates a form to delete a CauseResiliation entity by id.
     *
     * @param mixed $id
     *            The entity id
     *            
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cause_resiliation_delete', array(
            'id' => $id
        )))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array(
            'label' => 'Delete'
        ))
            ->getForm();
    }
}

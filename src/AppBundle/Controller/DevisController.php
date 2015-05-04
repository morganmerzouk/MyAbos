<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class DevisController extends Controller
{

    public function emailAction()
    {
        $id = $this->get('request')->get($this->admin->getIdParameter());
        $object = $this->admin->getObject($id);
        
        $message = \Swift_Message::newInstance()->setSubject('Hello Email')
            ->setFrom('send@example.com')
            ->setTo('morgan.merzouk@gmail.com')
            ->setBody($this->renderView('AppBundle:Front:devis.html.twig', array(
            'id' => $id,
            'devis' => $object
        )));
        $this->get('mailer')->send($message);
        $object->setSendAt(new \Datetime());
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($object);
        $em->flush();
        $this->addFlash('sonata_flash_success', 'Mail sent successfully');
        
        return new RedirectResponse($this->admin->generateUrl('list'));
    }
}

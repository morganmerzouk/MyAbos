<?php
namespace App\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\MainBundle\Form\ContactType;

class DefaultController extends Controller
{

    public function indexAction(Request $request)
    {
        $user = $this->get('security.token_storage')
            ->getToken()
            ->getUser();
        /*
         * $message = \Swift_Message::newInstance()->setSubject('Hello Email')
         * ->setFrom('send@example.com')
         * ->setTo('morgan.merzouk@gmail.com')
         * ->setBody("test");
         *
         * $this->container->get('mailer')->send($message);
         */
        if ($user == "anon.")
            return $this->render('AppMainBundle:Default:index.html.twig', array());
        else
            return $this->redirectToRoute('app_front_office_contract_list');
    }

    public function securiteAction(Request $request)
    {
        return $this->render('AppMainBundle:Default:securite.html.twig', array());
    }

    public function cgvAction(Request $request)
    {
        return $this->render('AppMainBundle:Default:cgv.html.twig', array());
    }

    public function contactAction()
    {
        $form = $this->createForm(new ContactType($this->getDoctrine()
            ->getEntityManager(), $this->getRequest()
            ->getLocale()));
        
        return $this->render('AppMainBundle:Default:contact.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function contactSendAction()
    {
        $locale = $this->getRequest()->getLocale();
        
        $email = $this->getRequest()->request->get('email');
        $nom = $this->getRequest()->request->get('nom');
        $message = $this->getRequest()->request->get('message');
        
        $demande = \Swift_Message::newInstance()->setSubject('MYABOS: Nouveau message de ' . $nom)
            ->setFrom($email)
            ->setTo($this->container->getParameter('contact_email'))
            ->setBody($message, 'text/html');
        
        $this->get('mailer')->send($demande);
        
        return new Response("OK");
    }
}
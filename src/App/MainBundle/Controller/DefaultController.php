<?php
namespace App\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
}
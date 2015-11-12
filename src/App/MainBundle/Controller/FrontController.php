<?php
namespace App\MainBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FrontController extends Controller
{

    public function indexAction(Request $request)
    {
        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage->addMeta('name', 'keyword', $this->get('translator')
            ->trans("home_meta_keywords"))
            ->addMeta('name', 'description', $this->get('translator')
            ->trans("home_meta_description"));
        
        return $this->render('AppBundle:Front:home.html.twig', array());
    }

    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function dashboardAction()
    {
        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage->addMeta('name', 'keyword', $this->get('translator')
            ->trans("dashboard_meta_keywords"))
            ->addMeta('name', 'description', $this->get('translator')
            ->trans("dashboard_meta_description"));
        return $this->render('AppBundle:Front:dashboard.html.twig');
    }

    /**
     * @Route("/mentionslegales", name="mentionslegales")
     */
    public function mentionsLegalesAction()
    {
        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage->addMeta('name', 'keyword', $this->get('translator')
            ->trans("legals_meta_keywords"))
            ->addMeta('name', 'description', $this->get('translator')
            ->trans("legals_meta_description"));
        return $this->render('AppBundle:Front:mentionslegales.html.twig');
    }

    /**
     * @Route("/sitemap", name="sitemap")
     */
    public function sitemapAction()
    {
        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage->addMeta('name', 'keyword', $this->get('translator')
            ->trans("sitemap_meta_keywords"))
            ->addMeta('name', 'description', $this->get('translator')
            ->trans("sitemap_meta_description"));
        
        $locale = $this->getRequest()->getLocale();
        
        return $this->render('AppBundle:Front:sitemap.html.twig', array());
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contactAction()
    {
        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage->addMeta('name', 'keyword', $this->get('translator')
            ->trans("contact_meta_keywords"))
            ->addMeta('name', 'description', $this->get('translator')
            ->trans("contact_meta_description"));
        
        $form = $this->createForm(new ContactType($this->getDoctrine()
            ->getEntityManager(), $this->getRequest()
            ->getLocale()));
        
        return $this->render('AppBundle:Front:contact.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/contact_send", name="contact_send")
     */
    public function contactSendAction()
    {
        $locale = $this->getRequest()->getLocale();
        
        $email = $this->getRequest()->request->get('email');
        $nom = $this->getRequest()->request->get('nom');
        $message = $this->getRequest()->request->get('message');
        
        $demande = \Swift_Message::newInstance()->setSubject('MyAbos: Nouveau message de ' . $nom)
            ->setFrom($email)
            ->setTo($this->container->getParameter('contact_email'))
            ->setBody($message, 'text/html');
        
        $this->get('mailer')->send($demande);
        
        return new Response("OK");
    }

    /**
     * @Route("/faq", name="faq")
     */
    public function faqAction()
    {
        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage->addMeta('name', 'keyword', $this->get('translator')
            ->trans("faq_meta_keywords"))
            ->addMeta('name', 'description', $this->get('translator')
            ->trans("faq_meta_description"));
        return $this->render('AppBundle:Front:faq.html.twig');
    }
}

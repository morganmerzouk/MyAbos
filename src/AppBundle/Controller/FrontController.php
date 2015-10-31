<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\SearchHeaderType;
use AppBundle\Form\ContactType;
use Symfony\Component\HttpFoundation\Response;

class FrontController extends Controller
{

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage->addMeta('name', 'keyword', $this->get('translator')
            ->trans("home_meta_keywords"))
            ->addMeta('name', 'description', $this->get('translator')
            ->trans("home_meta_description"));
        
        $locale = $this->getRequest()->getLocale();
        
        return $this->render('AppBundle:Front:home.html.twig', array());
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

    /**
     * @Route("/newsletter_subscribe", name="newsletter_subscribe")
     */
    public function newsletterAction()
    {
        $email = $this->getRequest()->request->get('email');
        
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $mc = $this->get('hype_mailchimp');
            $data = $mc->getList()->subscribe($email, 'html', false);
            $success = 1;
        } else {
            $success = 0;
        }
        
        return new Response($success);
    }

    public function menuHeaderAction($route)
    {
        $locale = $this->getRequest()->getLocale();
        return $this->render('AppBundle:Front:menu.html.twig', array());
    }
}

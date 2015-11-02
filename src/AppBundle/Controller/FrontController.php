<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Form\UserType;

class FrontController extends Controller
{

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage->addMeta('name', 'keyword', $this->get('translator')
            ->trans("home_meta_keywords"))
            ->addMeta('name', 'description', $this->get('translator')
            ->trans("home_meta_description"));
        
        $locale = $this->getRequest()->getLocale();
        
        // 1) build the form
        $user = new User();
        $form = $this->createForm(new UserType(), $user);
        
        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isValid() && $form->isSubmitted()) {
            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $this->get('security.password_encoder')->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            
            // 4) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            
            // ... do any other work - like send them an email, etc
            // maybe set a "flash" success message for the user
            
            return $this->redirectToRoute('dashboard');
        }
        
        return $this->render('AppBundle:Front:home.html.twig', array(
            'form' => $form->createView()
        ));
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

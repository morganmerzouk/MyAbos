<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\SearchHeaderType;
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
        $offresSpeciales = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\OffreSpeciale")
            ->createQueryBuilder('os')
            ->select('os, t')
            ->join('os.translations', 't')
            ->andWhere('t.locale = :locale')
            ->setParameter(':locale', $locale)
            ->getQuery()
            ->getResult();
        
        $destinations = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\Destination")
            ->createQueryBuilder('d')
            ->select('d, t')
            ->join('d.translations', 't')
            ->andWhere('t.locale = :locale')
            ->setParameter(':locale', $locale)
            ->getQuery()
            ->getResult();
        
        $boats = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\Bateau")
            ->createQueryBuilder('b')
            ->select('b, t')
            ->join('b.translations', 't')
            ->andWhere('t.locale = :locale')
            ->setParameter(':locale', $locale)
            ->getQuery()
            ->getResult();
        
        return $this->render('AppBundle:Front:home.html.twig', array(
            'offresSpeciales' => $offresSpeciales,
            'destinations' => $destinations,
            'boats' => $boats
        ));
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
        return $this->render('AppBundle:Front:sitemap.html.twig');
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
        return $this->render('AppBundle:Front:contact.html.twig');
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
        
        $destinations = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\Destination")
            ->createQueryBuilder('s')
            ->select('s, t')
            ->join('s.translations', 't')
            ->andWhere('t.locale = :locale')
            ->setParameter(':locale', $locale)
            ->getQuery()
            ->getResult();
        return $this->render('AppBundle:Front:menu.html.twig', array(
            'menuDestinations' => $destinations,
            'route' => $route
        ));
    }
}

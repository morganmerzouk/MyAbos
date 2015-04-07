<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\SearchHeaderType;

class FrontController extends Controller
{

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
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
        
        return $this->render('AppBundle:Front:home.html.twig', array(
            'offresSpeciales' => $offresSpeciales
        ));
    }

    /**
     * @Route("/mentionslegales", name="mentionslegales")
     */
    public function mentionsLegalesAction()
    {
        return $this->render('AppBundle:Front:mentionslegales.html.twig');
    }

    /**
     * @Route("/sitemap", name="sitemap")
     */
    public function sitemapAction()
    {
        return $this->render('AppBundle:Front:sitemap.html.twig');
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contactAction()
    {
        return $this->render('AppBundle:Front:contact.html.twig');
    }
}

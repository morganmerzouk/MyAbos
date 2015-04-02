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
     * @Route("/offresspeciales", name="offresSpeciales")
     */
    public function offresSpecialesAction()
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
        return $this->render('AppBundle:Front:offresspeciales.html.twig', array(
            'offresSpeciales' => $offresSpeciales
        ));
    }

    public function searchHeaderAction()
    {
        $form = $this->createForm(new SearchHeaderType($this->getDoctrine()
            ->getEntityManager(), $this->getRequest()
            ->getLocale()));
        return $this->render('AppBundle:Front:form/search_header.html.twig', array(
            'form' => $form->createView()
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

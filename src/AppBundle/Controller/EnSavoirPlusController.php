<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EnSavoirPlusController extends Controller
{

    /**
     * @Route("/ensavoirplus", name="ensavoirplus")
     */
    public function indexAction()
    {
        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage->addMeta('name', 'keyword', $this->get('translator')
            ->trans("about_meta_keywords"))
            ->addMeta('name', 'description', $this->get('translator')
            ->trans("about_meta_description"));
        
        return $this->render('AppBundle:Front:ensavoirplus/ensavoirplus.html.twig');
    }

    /**
     * @Route("/ensavoirplus/croisiere", name="ensavoirplus_croisiere")
     */
    public function croisiereAction()
    {
        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage->addMeta('name', 'keyword', $this->get('translator')
            ->trans("about_cruise_meta_keywords"))
            ->addMeta('name', 'description', $this->get('translator')
            ->trans("about_cruise_meta_description"));
        
        return $this->render('AppBundle:Front:ensavoirplus/ensavoirplus_croisiere.html.twig');
    }

    /**
     * @Route("/ensavoirplus/reseau", name="ensavoirplus_reseau")
     */
    public function reseauAction()
    {
        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage->addMeta('name', 'keyword', $this->get('translator')
            ->trans("about_network_meta_keywords"))
            ->addMeta('name', 'description', $this->get('translator')
            ->trans("about_network_meta_description"));
        
        return $this->render('AppBundle:Front:ensavoirplus/ensavoirplus_reseau.html.twig');
    }

    /**
     * @Route("/ensavoirplus/meteo", name="ensavoirplus_meteo")
     */
    public function meteoAction()
    {
        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage->addMeta('name', 'keyword', $this->get('translator')
            ->trans("about_weather_meta_keywords"))
            ->addMeta('name', 'description', $this->get('translator')
            ->trans("about_weather_meta_description"));
        
        return $this->render('AppBundle:Front:ensavoirplus/ensavoirplus_meteo.html.twig');
    }
}

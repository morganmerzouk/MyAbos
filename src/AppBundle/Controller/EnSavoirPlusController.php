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
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://api.weatherunlocked.com/api/forecast/19,-72?app_id=361f6a5c&app_key=fd5c716dcc505124543301d907c3d6de");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $test = curl_exec($ch);
        var_dump($test);
        return $this->render('AppBundle:Front:ensavoirplus/ensavoirplus_meteo.html.twig');
    }
}

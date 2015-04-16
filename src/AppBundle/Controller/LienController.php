<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LienController extends Controller
{

    /**
     * @Route("/liens", name="liens")
     */
    public function indexAction()
    {
        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage->addMeta('name', 'keyword', $this->get('translator')
            ->trans("links_meta_keywords"))
            ->addMeta('name', 'description', $this->get('translator')
            ->trans("links_meta_description"));
        
        return $this->render('AppBundle:Front:liens.html.twig');
    }
}

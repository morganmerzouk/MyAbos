<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DestinationController extends Controller
{

    /**
     * @Route("/destinations", name="destinations")
     */
    public function indexAction()
    {
        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage->addMeta('name', 'keyword', $this->get('translator')
            ->trans("destinations_meta_keywords"))
            ->addMeta('name', 'description', $this->get('translator')
            ->trans("destinations_meta_description"));
        
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
        return $this->render('AppBundle:Front:destinations.html.twig', array(
            'destinations' => $destinations
        ));
    }

    /**
     * @Route("/destination/{id}", requirements={"id" = "\d+"}, name="destination")
     */
    public function destinationAction($id)
    {
        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage->addMeta('name', 'keyword', $this->get('translator')
            ->trans("destination_meta_keywords"))
            ->addMeta('name', 'description', $this->get('translator')
            ->trans("destination_meta_description"));
        
        $locale = $this->getRequest()->getLocale();
        
        $destination = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\Destination")
            ->createQueryBuilder('s')
            ->select('s, t')
            ->join('s.translations', 't')
            ->where('s.id = :id')
            ->setParameter(':id', $id)
            ->andWhere('t.locale = :locale')
            ->setParameter(':locale', $locale)
            ->getQuery()
            ->getSingleResult();
        
        $seoPage->addMeta('name', 'keyword', $destination->getName());
        $seoPage->addMeta('name', 'description', substr($destination->getDescription(), 0, 255));
        $offresSpeciales = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\OffreSpeciale")
            ->createQueryBuilder('os')
            ->select('os, t')
            ->join('os.translations', 't')
            ->andWhere('os.destination = :destination')
            ->setParameter(':destination', $id)
            ->andWhere('t.locale = :locale')
            ->setParameter(':locale', $locale)
            ->getQuery()
            ->getResult();
        return $this->render('AppBundle:Front:destination.html.twig', array(
            'destination' => $destination,
            'offresSpeciales' => $offresSpeciales
        ));
    }
}

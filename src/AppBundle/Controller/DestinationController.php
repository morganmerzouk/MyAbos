<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Cmfcmf\OpenWeatherMap;
use Cmfcmf\OpenWeatherMap\Exception as OWMException;

class DestinationController extends Controller
{

    /**
     * @Route("/destinations", name="destinations")
     */
    public function indexAction()
    {
        $seoPage = $this->container->get('sonata.seo.page');
        
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
        $seo = "";
        foreach ($destinations as $destination) {
            $seo .= ',' . $destination->getName();
        }
        $seoPage->addMeta('name', 'keyword', $this->get('translator')
            ->trans("destinations_meta_keywords") . $seo)
            ->addMeta('name', 'description', $this->get('translator')
            ->trans("destinations_meta_description"));
        
        return $this->render('AppBundle:Front:destinations.html.twig', array(
            'destinations' => $destinations
        ));
    }

    /**
     * @Route("/destination/{id}/{slug}", requirements={"id" = "\d+"}, name="destination")
     */
    public function destinationAction($id)
    {
        $seoPage = $this->container->get('sonata.seo.page');
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
        
        $seoPage->addMeta('name', 'keyword', $destination->getName() . ',' . $this->get('translator')
            ->trans("destination_meta_keywords"));
        $seoPage->addMeta('name', 'description', substr(strip_tags($destination->getDescription()), 0, 255));
        
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
        
        $units = $locale == "en" ? 'imperial' : 'metric';
        $owm = new OpenWeatherMap();
        
        $weather = null;
        try {
            $weather = $owm->getWeatherForecast($destination->getName(), $units, $locale, '', '10');
        } catch (OWMException $e) {} catch (\Exception $e) {}
        
        // API Flickr
        $url = $this->container->getParameter('flickr_url') . '&lat=' . $destination->getLatitude() . '&lon=' . $destination->getLongitude();
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        
        $media = new \SimpleXMLElement($response);
        
        return $this->render('AppBundle:Front:destination.html.twig', array(
            'destination' => $destination,
            'offresSpeciales' => $offresSpeciales,
            'weathers' => $weather,
            'media' => $media->children()
                ->children()
        ));
    }
}

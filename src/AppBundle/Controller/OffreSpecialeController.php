<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\Query;
use AppBundle\Form\OffreSpecialeContactType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Devis;
use Cmfcmf\OpenWeatherMap;
use Cmfcmf\OpenWeatherMap\Exception as OWMException;

class OffreSpecialeController extends Controller
{

    /**
     * @Route("/offres-speciales", name="offresspeciales")
     */
    public function offresSpecialesAction()
    {
        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage->addMeta('name', 'keyword', $this->get('translator')
            ->trans("specialoffers_meta_keywords"))
            ->addMeta('name', 'description', $this->get('translator')
            ->trans("specialoffers_meta_description"));
        
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
        return $this->render('AppBundle:Front:OffreSpeciale/offresspeciales.html.twig', array(
            'offresSpeciales' => $offresSpeciales
        ));
    }

    /**
     * @Route("/offre-speciale/{id}/{slug}", requirements={"id" = "\d+"}, name="offrespeciale")
     */
    public function offreSpecialeAction($id)
    {
        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage->addMeta('name', 'keyword', $this->get('translator')
            ->trans("specialoffer_meta_keywords"))
            ->addMeta('name', 'description', $this->get('translator')
            ->trans("specialoffer_meta_description"));
        
        $locale = $this->getRequest()->getLocale();
        
        $offreSpeciale = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\OffreSpeciale")
            ->createQueryBuilder('os')
            ->select('os, s, ost, st')
            ->join('AppBundle\Entity\Skipper', 's', 'WITH', 'os.skipper = s.id')
            ->join('os.translations', 'ost')
            ->join('s.translations', 'st')
            ->where('os.id = :id')
            ->setParameter(':id', $id)
            ->andWhere('ost.locale = :locale')
            ->andWhere('st.locale = :locale')
            ->setParameter(':locale', $locale)
            ->getQuery()
            ->getResult(Query::HYDRATE_OBJECT);
        
        $seoPage->addMeta('name', 'keyword', $offreSpeciale[0]->getName());
        $seoPage->addMeta('name', 'description', substr($offreSpeciale[0]->getDescription(), 0, 255));
        
        $servicePayant = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\ServicePayant")
            ->createQueryBuilder('s')
            ->select('s, t')
            ->join('s.translations', 't')
            ->where('s.bateau = :id')
            ->orderby('s.categorie', 'ASC')
            ->setParameter(':id', $offreSpeciale[0]->getBateau()
            ->getId())
            ->getQuery()
            ->getResult();
        
        $inclusPrix = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\Bateau")
            ->createQueryBuilder('b')
            ->select('b, ipe, ipa, ipf, ipet, ipac, ipc, ipas')
            ->leftJoin('b.inclusPrixEquipage', 'ipe')
            ->leftJoin('b.inclusPrixAvitaillement', 'ipa')
            ->leftJoin('b.inclusPrixFraisVoyage', 'ipf')
            ->leftJoin('b.inclusPrixEquipement', 'ipet')
            ->leftJoin('b.inclusPrixActivite', 'ipac')
            ->leftJoin('b.inclusPrixCours', 'ipc')
            ->leftJoin('b.inclusPrixAutresServices', 'ipas')
            ->where('b.id = :id')
            ->setParameter(':id', $offreSpeciale[0]->getBateau()
            ->getId())
            ->getQuery()
            ->getResult();
        
        $ids = array();
        
        if (isset($inclusPrix[0]) && $inclusPrix[0]->getInclusPrixEquipage() != null)
            array_push($ids, $inclusPrix[0]->getInclusPrixEquipage()->getId());
        foreach ($inclusPrix[0]->getInclusPrixAvitaillement() as $inclusPrixAvitaillement)
            array_push($ids, $inclusPrixAvitaillement->getId());
        foreach ($inclusPrix[0]->getInclusPrixFraisVoyage() as $inclusPrixFraisVoyage)
            array_push($ids, $inclusPrixFraisVoyage->getId());
        foreach ($inclusPrix[0]->getInclusPrixEquipement() as $inclusPrixEquipement)
            array_push($ids, $inclusPrixEquipement->getId());
        foreach ($inclusPrix[0]->getInclusPrixActivite() as $inclusPrixActivite)
            array_push($ids, $inclusPrixActivite->getId());
        foreach ($inclusPrix[0]->getInclusPrixCours() as $inclusPrixCours)
            array_push($ids, $inclusPrixCours->getId());
        foreach ($inclusPrix[0]->getInclusPrixAutresServices() as $inclusPrixAutresServices)
            array_push($ids, $inclusPrixAutresServices->getId());
        
        $inclusPrix2 = $this->getDoctrine()
            ->getManager()
            ->createQueryBuilder('ip')
            ->select('ip,p,pt')
            ->from("AppBundle\Entity\InclusPrix", "ip")
            ->join('ip.prestation', 'p')
            ->join('p.translations', 'pt')
            ->andWhere('pt.locale = :locale')
            ->andWhere('ip.id IN (' . implode(',', $ids) . ')')
            ->setParameter(':locale', $locale)
            ->getQuery()
            ->getResult();
        if (count($inclusPrix2) > 0) {
            $idPrestations = array();
            foreach ($inclusPrix2[0]->getPrestation() as $prestation) {
                array_push($idPrestations, $prestation->getId());
            }
            
            $prestation = $this->getDoctrine()
                ->getManager()
                ->createQueryBuilder('p')
                ->select('p,pt')
                ->from("AppBundle\Entity\Prestation", "p")
                ->join('p.translations', 'pt')
                ->andWhere('pt.locale = :locale')
                ->andWhere('p.id IN (' . implode(',', $idPrestations) . ')')
                ->setParameter(':locale', $locale)
                ->getQuery()
                ->getResult();
        } else {
            $prestation = null;
        }
        
        /**
         * * Formulaire de contact **
         */
        $form = $this->createForm(new OffreSpecialeContactType($this->getDoctrine()
            ->getEntityManager(), $this->getRequest()
            ->getLocale()));
        
        $units = $locale == "en" ? 'imperial' : 'metric';
        $owm = new OpenWeatherMap();
        
        $weather = null;
        try {
            $weather = $owm->getWeatherForecast($offreSpeciale[0]->getDestination()
                ->getName(), $units, $locale, '', '10');
        } catch (OWMException $e) {} catch (\Exception $e) {}
        
        // API Flickr
        $url = $this->container->getParameter('flickr_url') . '&lat=' . $offreSpeciale[0]->getDestination()->getLatitude() . '&lon=' . $offreSpeciale[0]->getDestination()->getLongitude();
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        
        $media = new \SimpleXMLElement($response);
        
        return $this->render('AppBundle:Front:OffreSpeciale/offrespeciale.html.twig', array(
            'offreSpeciale' => isset($offreSpeciale[0]) ? $offreSpeciale[0] : null,
            'skipper' => isset($offreSpeciale[0]) ? $offreSpeciale[0]->getSkipper() : null,
            'boat' => isset($offreSpeciale[0]) ? $offreSpeciale[0]->getBateau() : null,
            'destination' => isset($offreSpeciale[0]) ? $offreSpeciale[0]->getDestination() : null,
            'weathers' => $weather,
            'media' => $media->children()
                ->children(),
            'inclusprixavitaillement' => $offreSpeciale[0]->getBateau()
                ->getInclusPrixAvitaillement(),
            'inclusprixequipage' => $offreSpeciale[0]->getBateau()
                ->getInclusPrixEquipage(),
            'inclusprixfraisdevoyage' => $offreSpeciale[0]->getBateau()
                ->getInclusPrixFraisVoyage(),
            'inclusprixautresservices' => $offreSpeciale[0]->getBateau()
                ->getInclusPrixAutresServices(),
            'inclusprixequipement' => $offreSpeciale[0]->getBateau()
                ->getInclusPrixEquipement(),
            'inclusprixactivite' => $offreSpeciale[0]->getBateau()
                ->getInclusPrixActivite(),
            'inclusprixcours' => $offreSpeciale[0]->getBateau()
                ->getInclusPrixCours(),
            'servicepayant' => $servicePayant,
            'prestations' => $prestation,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/offrespeciale/{id}/contact/send", requirements={"id" = "\d+"}, name="offrespeciale_contact_send")
     */
    public function offreSpecialeContactSendAction($id)
    {
        $locale = $this->getRequest()->getLocale();
        
        $email = $this->getRequest()->request->get('email');
        $nom = $this->getRequest()->request->get('nom');
        $message = $this->getRequest()->request->get('message');
        if ($this->getRequest()->request->get('servicePayant')) {
            $servicePayant_id = array_values($this->getRequest()->request->get('servicePayant'));
            $servicesPayant = $this->getDoctrine()
                ->getManager()
                ->getRepository("AppBundle\Entity\ServicePayant")
                ->createQueryBuilder('sp')
                ->select('sp, t')
                ->join('sp.translations', 't')
                ->where('sp.id IN (:id)')
                ->andWhere('t.locale = :locale')
                ->setParameter(':locale', $locale)
                ->setParameter(':id', $servicePayant_id)
                ->getQuery()
                ->getResult();
            $html = "";
            foreach ($servicesPayant as $servicePayant) {
                $html .= $servicePayant->getName() . '<br />';
            }
        }
        $devis = new Devis();
        $devis->setOffreSpecialeId($id)
            ->setNom($nom)
            ->setEmail($email)
            ->setMessage($message)
            ->setCreatedAt(new \DateTime("now"));
        if (isset($html)) {
            $devis->setServicePayant($html);
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($devis);
        $em->flush();
        
        return new Response("OK");
    }

    public function subMenuAction($id)
    {
        $locale = $this->getRequest()->getLocale();
        
        $offrespeciale = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\OffreSpeciale")
            ->createQueryBuilder('os')
            ->select('os, t')
            ->join('os.translations', 't')
            ->where('os.id = :id')
            ->setParameter(':id', $id)
            ->andWhere('t.locale = :locale')
            ->setParameter(':locale', $locale)
            ->getQuery()
            ->getSingleResult();
        
        return $this->render('AppBundle:Front:OffreSpeciale/offrespeciale_submenu.html.twig', array(
            'offrespeciale' => $offrespeciale
        ));
    }
}

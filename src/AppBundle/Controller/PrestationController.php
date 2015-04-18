<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\Query;

class PrestationController extends Controller
{

    /**
     * @Route("/prestations", name="prestations")
     */
    public function indexAction()
    {
        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage->addMeta('name', 'keyword', $this->get('translator')
            ->trans("services_meta_keywords"))
            ->addMeta('name', 'description', $this->get('translator')
            ->trans("services_meta_description"));
        
        $locale = $this->getRequest()->getLocale();
        
        $prestations = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\Prestation")
            ->createQueryBuilder('s')
            ->select('s, t')
            ->join('s.translations', 't')
            ->andWhere('t.locale = :locale')
            ->setParameter(':locale', $locale)
            ->getQuery()
            ->getResult();
        return $this->render('AppBundle:Front:prestations.html.twig', array(
            'prestations' => $prestations
        ));
    }

    /**
     * @Route("/prestation/{id}", requirements={"id" = "\d+"}, name="prestation")
     */
    public function prestationAction($id)
    {
        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage->addMeta('name', 'keyword', $this->get('translator')
            ->trans("destination_meta_keywords"))
            ->addMeta('name', 'description', $this->get('translator')
            ->trans("destination_meta_description"));
        
        $locale = $this->getRequest()->getLocale();
        
        $prestation = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\Prestation")
            ->createQueryBuilder('s')
            ->select('s, t')
            ->join('s.translations', 't')
            ->where('s.id = :id')
            ->setParameter(':id', $id)
            ->andWhere('t.locale = :locale')
            ->setParameter(':locale', $locale)
            ->getQuery()
            ->getSingleResult();
        
        $seoPage->addMeta('name', 'keyword', $prestation->getName());
        $seoPage->addMeta('name', 'description', substr($prestation->getDescription(), 0, 255));
        $prestationsMenu = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\Prestation")
            ->createQueryBuilder('s')
            ->select('s, t')
            ->join('s.translations', 't')
            ->andWhere('t.locale = :locale')
            ->setParameter(':locale', $locale)
            ->getQuery()
            ->getResult();
        
        $bateaux = $this->getDoctrine()
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
            ->getQuery()
            ->getResult(Query::HYDRATE_OBJECT);
        
        $ids = array();
        
        $boats = array();
        foreach ($bateaux as $bateau) {
            if ($bateau->getInclusPrixEquipage() != null && count($bateau->getInclusPrixEquipage()->getPrestation()) > 0) {
                foreach ($bateau->getInclusPrixEquipage()->getPrestation() as $laprestation) {
                    if ($laprestation->getId() == $id)
                        array_push($boats, $bateau);
                }
            }
            $inclusPrix = array_merge($bateau->getInclusPrixAvitaillement()->toArray(), $bateau->getInclusPrixFraisVoyage()->toArray(), $bateau->getInclusPrixEquipement()->toArray(), $bateau->getInclusPrixActivite()->toArray(), $bateau->getInclusPrixCours()->toArray(), $bateau->getInclusPrixAutresServices()->toArray());
            foreach ($inclusPrix as $unInclusPrix) {
                foreach ($unInclusPrix->getPrestation() as $uneprestation) {
                    if ($uneprestation->getId() == $id) {
                        array_push($boats, $bateau);
                    }
                }
            }
        }
        
        return $this->render('AppBundle:Front:prestation.html.twig', array(
            'prestationsMenu' => $prestationsMenu,
            'prestation' => $prestation,
            'boats' => $boats
        ));
    }
}

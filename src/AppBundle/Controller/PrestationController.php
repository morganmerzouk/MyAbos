<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PrestationController extends Controller
{

    /**
     * @Route("/prestations", name="prestations")
     */
    public function indexAction()
    {
        $request = $this->getRequest();
        $locale = $request->getLocale();
        
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
        $request = $this->getRequest();
        $locale = $request->getLocale();
        
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
        
        $prestationsName = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\Prestation")
            ->createQueryBuilder('s')
            ->select('s.id, t.name')
            ->join('s.translations', 't')
            ->andWhere('t.locale = :locale')
            ->setParameter(':locale', $locale)
            ->getQuery()
            ->getResult();
        
        return $this->render('AppBundle:Front:prestation.html.twig', array(
            'prestationsName' => $prestationsName,
            'prestation' => $prestation
        ));
    }
}

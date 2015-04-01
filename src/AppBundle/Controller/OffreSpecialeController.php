<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class OffreSpecialeController extends Controller
{

    /**
     * @Route("/offresspeciales", name="offresspeciales")
     */
    public function indexAction()
    {
        return $this->render('AppBundle:Front:offresspeciales.html.twig');
    }

    /**
     * @Route("/offrespeciale/{id}", requirements={"id" = "\d+"}, name="offrespeciale")
     */
    public function offrespecialeAction($id)
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
        
        return $this->render('AppBundle:Front:offrespeciale.html.twig', array(
            'offrespeciale' => $offrespeciale
        ));
    }
}

<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Helper\TransparentPixelResponse;
use AppBundle\Helper\AppBundle\Helper;

class TrackingController extends Controller
{

    /**
     * @Route("/track.gif")
     */
    public function emailAction(Request $request)
    {
        $id = $request->query->getId();
        if ($id !== null) {
            // On récupère le devis et on le met comme lu
            $devis = $this->getDoctrine()
                ->getManager()
                ->getRepository("AppBundle\Entity\Devis")
                ->createQueryBuilder('d')
                ->select('d')
                ->where('d.id = :id')
                ->setParameter(':id', $id)
                ->getQuery()
                ->getSingleResult();
            $devis->setReadAt(new \DateTime());
        }
        return new TransparentPixelResponse();
    }
}
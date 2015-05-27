<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class DevisController extends Controller
{

    public function emailAction()
    {
        $id = $this->get('request')->get($this->admin->getIdParameter());
        $object = $this->admin->getObject($id);
        
        $mailRaw = explode('@', $this->container->getParameter('contact_email'));
        $hash = '+' . hash('md5', $id);
        $mailSender = $mailRaw[0] . $hash . '@' . $mailRaw[1];
        
        // On envoie l'email suite à une offre spéciale
        if ($object->getOffreSpecialeId() != "") {
            $offreSpeciale = $this->getDoctrine()
                ->getManager()
                ->getRepository("AppBundle\Entity\OffreSpeciale")
                ->createQueryBuilder('os')
                ->select('os')
                ->where('os.id = :id')
                ->setParameter(':id', $object->getOffreSpecialeId())
                ->getQuery()
                ->getSingleResult();
            $skipper = $offreSpeciale->getSkipper();
        } else {
            $skipper = $this->getDoctrine()
                ->getManager()
                ->getRepository("AppBundle\Entity\Skipper")
                ->createQueryBuilder('s')
                ->select('s')
                ->where('s.name = :name')
                ->setParameter(':name', $object->getSkipper())
                ->getQuery()
                ->getSingleResult();
        }
        
        $mailRecipient = $skipper->getEmail();
        
        $message = \Swift_Message::newInstance()->setSubject('Kitesurfeo: Demande de contact')
            ->setFrom($mailSender)
            ->setTo($mailRecipient)
            ->setBody($this->renderView('AppBundle:Front:devis.html.twig', array(
            'id' => $id,
            'devis' => $object,
            'skipper' => $skipper,
            'mailSender' => $mailSender,
            'mailRecipient' => $mailRecipient
        )), 'text/html');
        
        $this->get('mailer')->send($message);
        
        $object->setSendAt(new \Datetime());
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($object);
        $em->flush();
        $this->addFlash('sonata_flash_success', 'Mail sent successfully');
        
        return new RedirectResponse($this->admin->generateUrl('list'));
    }

    /**
     * @Route("/devis_delete/{id}", requirements={"id" = "\d+"}, name="devis_delete")
     */
    public function deleteAction($id)
    {
        $devis = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\Devis")
            ->createQueryBuilder('d')
            ->select('d')
            ->where('d.id = :id')
            ->setParameter(':id', $id)
            ->getQuery()
            ->getSingleResult();
        
        $devis->setActif(false);
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($devis);
        $em->flush();
        $this->addFlash('sonata_flash_success', 'Estimate deleted successfully');
        
        return new RedirectResponse($this->admin->generateUrl('list'));
    }
}

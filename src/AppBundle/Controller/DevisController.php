<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class DevisController extends Controller
{

    /**
     * @Route("/enquiry_manager", name="enquiry_manager")
     */
    public function indexAction()
    {
        $deviss = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\Devis")
            ->createQueryBuilder('d')
            ->select('d')
            ->where('d.actif = 1')
            ->getQuery()
            ->getResult();
        
        $mailbox = "{imap.gmail.com:993/imap/ssl}INBOX";
        $mbx = imap_open($mailbox, $this->container->getParameter('contact_email'), $this->container->getParameter('mailer_password'));
        $ck = imap_check($mbx);
        $emails = imap_search($mbx, 'ALL');
        if ($emails) {
            foreach ($emails as &$email) {
                $mail = imap_fetch_overview($mbx, $email, 0)[0];
                $mail->from = imap_utf8($mail->from);
                $mail->to = imap_utf8($mail->to);
                $mail->message = quoted_printable_decode(imap_fetchbody($mbx, $email, 2));
                
                $mail->devisId = explode('+', explode('@', $mail->to)[0])[1];
                $mail->id = $email;
                foreach ($deviss as &$devis) {
                    if ($devis->getId() == $mail->devisId) {
                        $devis->addMails($mail);
                    }
                }
            }
        }
        return $this->render('AppBundle:Front:enquiry_manager.html.twig', array(
            "deviss" => $deviss
        ));
    }

    /**
     * @Route("/devis_email/{id}/{to}/{messageId}", requirements={"id" = "\d+"}, name="devis_email")
     */
    public function emailAction($id, $to, $messageId = null)
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
        
        if ($to == "skipper") {
            $skipper = $this->getDoctrine()
                ->getManager()
                ->getRepository("AppBundle\Entity\Skipper")
                ->createQueryBuilder('s')
                ->select('s')
                ->where('s.name = :name')
                ->setParameter(':name', $devis->getSkipper())
                ->getQuery()
                ->getSingleResult();
            
            $mailRecipient = $skipper->getEmail();
            $content = $this->renderView('AppBundle:Front:devis.html.twig', array(
                'id' => $id,
                'devis' => $devis,
                'skipper' => $skipper
            ));
        } elseif ($to == "client") {
            $mailRecipient = $devis->getEmail();
        }
        
        if ($messageId != null) {
            $mailbox = "{imap.gmail.com:993/imap/ssl}INBOX";
            $mbx = imap_open($mailbox, $this->container->getParameter('contact_email'), $this->container->getParameter('mailer_password'));
            $content = quoted_printable_decode(imap_fetchbody($mbx, $messageId, 2));
            var_dump($content);
        }
        
        $mailRaw = explode('@', $this->container->getParameter('contact_email'));
        $hash = '+' . $id;
        $mailSender = $mailRaw[0] . $hash . '@' . $mailRaw[1];
        
        $message = \Swift_Message::newInstance()->setSubject('Kitesurfeo: Demande de contact')
            ->setFrom($mailSender)
            ->setTo($mailRecipient)
            ->setReplyTo($mailSender)
            ->setBody($content, 'text/html');
        
        $this->get('mailer')->send($message);
        $devis->setSendAt(new \Datetime());
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($devis);
        $em->flush();
        
        $this->get('session')
            ->getFlashBag()
            ->add('notice', 'Mail envoyé avec succès');
        
        return new RedirectResponse($this->generateUrl('enquiry_manager'));
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
        
        $this->get('session')
            ->getFlashBag()
            ->add('notice', 'Demande supprimée avec succès');
        
        return new RedirectResponse($this->generateUrl('enquiry_manager'));
    }
}

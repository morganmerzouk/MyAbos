<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Form\RegistrationType;
use AppBundle\Entity\User;

class SecurityController extends Controller
{

    public function LoginBisAction()
    {
        $csrfToken = $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate');
        
        return $this->container->get('templating')->renderResponse('AppBundle:Security:login_content.html.twig', array(
            'last_username' => null,
            'error' => null,
            'csrf_token' => $csrfToken
        ));
    }

    public function registerBisAction(Request $request)
    {
        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage->addMeta('name', 'keyword', $this->get('translator')
            ->trans("home_meta_keywords"))
            ->addMeta('name', 'description', $this->get('translator')
            ->trans("home_meta_description"));
        
        $user = new User();
        $form = $this->createForm(new RegistrationType(), $user);
        $form->handleRequest($request);
        if ($form->isValid() && $form->isSubmitted()) {
            $password = $this->get('security.password_encoder')->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            
            return $this->redirectToRoute('profile');
        }
        
        return $this->container->get('templating')->renderResponse('AppBundle:Security:register.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
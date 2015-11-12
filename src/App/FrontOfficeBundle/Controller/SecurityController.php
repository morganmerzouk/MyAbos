<?php
namespace App\FrontOfficeBundle\Controller;

use FOS\UserBundle\Controller\SecurityController as BaseSecurityController;

class SecurityController extends BaseSecurityController
{

    /**
     * Renders the login template with the given parameters.
     * Overwrite this function in
     * an extended controller to provide additional data for the login template.
     *
     * @param array $data            
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderLogin(array $data)
    {
        return $this->container->get('templating')->renderResponse('AppFrontOfficeBundle:Security:login.html.twig', $data);
    }

    /**
     * Renders the register template with the given parameters.
     * Overwrite this function in
     * an extended controller to provide additional data for the login template.
     *
     * @param array $data            
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderRegister(array $data)
    {
        return $this->container->get('templating')->renderResponse('AppFrontOfficeBundle:Security:register.html.twig', $data);
    }
} 
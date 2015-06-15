<?php
namespace AppBundle\Listener;

use \Symfony\Component\HttpKernel\Event\GetResponseEvent;
use \Symfony\Component\HttpKernel\KernelEvents;
use \Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class LocaleListener implements EventSubscriberInterface
{

    protected $domainLocales;

    protected $defaultLocale;

    public function __construct($container, $defaultLocale)
    {
        $this->domainLocales = $container->getParameter('domain_locales');
        $this->defaultLocale = $defaultLocale;
    }

    /**
     * Set default locale
     *
     * @param GetResponseEvent $event            
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        // get domain name
        $host = $request->getHttpHost();
        
        $locale = $this->defaultLocale;
        
        if (array_key_exists($host, $this->domainLocales)) {
            $locale = $this->domainLocales[$host];
        }
        $request->setLocale($locale);
    }

    static public function getSubscribedEvents()
    {
        return array(
            // must be registered before the default Locale listener
            KernelEvents::REQUEST => array(
                array(
                    'onKernelRequest',
                    1
                )
            )
        );
    }
}
<?php
namespace AppBundle\Controller;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\HttpKernel;

class LocaleController implements EventSubscriberInterface
{

    public function onKernelRequest(GetResponseEvent $event)
    {
        if (HttpKernel::MASTER_REQUEST != $event->getRequestType()) {
            return;
        }
        $request = $event->getRequest();
        $host = $request->getHttpHost();
        if ($host == 'kitesurfeo.fr' || $host == 'www.kitesurfeo.fr') {
            $locale = 'fr';
        } elseif ($host == 'kitesurfeo.com' || $host == 'www.kitesurfeo.com') {
            $locale = 'en';
        } else {
            $locale = 'fr';
        }
        
        // on peut surcharger la langue en get
        if ($request->get('locale')) {
            $locale = $request->get('locale');
        }
        
        $request->setLocale($locale);
    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::REQUEST => array(
                array(
                    'onKernelRequest',
                    16
                )
            )
        );
    }
}
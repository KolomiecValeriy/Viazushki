<?php

namespace ViazushkiBundle\Listeners;

use Symfony\Component\EventDispatcher\Event;

class ResponseListener
{
    public function onKernelResponse(Event $event)
    {
        $response = $event->getResponse();

        $response->headers->set('PoweredBy', 'WordPress :)');
        return $response;
    }
}

<?php

namespace ViazushkiBundle\Listeners;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class AddHeaderListener
{
    private $headerName;
    private $headerValue;

    public function __construct($headerName, $headerValue)
    {
        $this->headerName = $headerName;
        $this->headerValue = $headerValue;

    }
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $response = $event->getResponse();

        $response->headers->set($this->headerName, $this->headerValue);
    }
}

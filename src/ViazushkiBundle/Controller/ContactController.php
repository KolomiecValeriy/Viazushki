<?php

namespace ViazushkiBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ContactController extends Controller
{
    public function contactAction()
    {
        return $this->render('@Viazushki/Contact/contact.html.twig');
    }
}
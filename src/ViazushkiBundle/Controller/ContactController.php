<?php

namespace ViazushkiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use ViazushkiBundle\Entity\Contact;
use ViazushkiBundle\Form\Type\ContactType;

class ContactController extends Controller
{
    public function contactAction(Request $request)
    {
        $contact = new Contact();
        $contactForm = $this->createForm(ContactType::class, $contact);
        $translator = $this->get('translator');

        $contactForm->handleRequest($request);
        if ($contactForm->isSubmitted() && $contactForm->isValid()) {

            $contactEmail = $this->container->get('viazushki.send_contact_email');
            $contactEmail->send(
                'Сообщение от Viazushki.in.ua',
                $contactForm->get('name')->getData(),
                $contactForm->get('email')->getData(),
                $contactForm->get('text')->getData()
            );

            return new JsonResponse(['message' => $translator->trans('message was successfully sent')]);
        }

        return $this->render('@Viazushki/Contact/contact.html.twig', [
            'contactForm' => $contactForm->createView(),
        ]);
    }
}

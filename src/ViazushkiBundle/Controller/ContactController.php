<?php

namespace ViazushkiBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ViazushkiBundle\Entity\Contact;
use ViazushkiBundle\Form\Type\ContactType;

class ContactController extends Controller
{
    public function contactAction(Request $request)
    {
        $contact = new Contact();
        $contactForm = $this->createForm(ContactType::class, $contact);


        if ($request->isMethod('post')) {
            $contactForm->handleRequest($request);

            if ($contactForm->isSubmitted() && $contactForm->isValid()) {

                $sendingMessage = $this->container->get('viazushki.sending_message');
                $sendingMessage->setEmail($contactForm->get('email')->getData());
                $sendingMessage->setBody(
                    $this->renderView('@Viazushki/Email/contactEmail.html.twig', [
                        'name' => $contactForm->get('name')->getData(),
                        'email' => $contactForm->get('email')->getData(),
                        'message' => $contactForm->get('text')->getData(),
                    ])
                );

                if($sendingMessage->send()) {
                    return $this->redirectToRoute('viazushki_contacts');
                }
            }

        }

        return $this->render('@Viazushki/Contact/contact.html.twig', [
            'contactForm' => $contactForm->createView(),
        ]);
    }
}

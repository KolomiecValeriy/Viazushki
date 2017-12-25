<?php

namespace ViazushkiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ViazushkiBundle\Entity\User;
use ViazushkiBundle\Form\Type\LoginType;
use ViazushkiBundle\Form\Type\RegisterType;

class SecurityController extends Controller
{
    public function loginAction()
    {
        $authUtils = $this->get('security.authentication_utils');

        $user = new User();
        $loginForm = $this->createForm(LoginType::class, $user);

        $error = $authUtils->getLastAuthenticationError();
        $lastUsername = $authUtils->getLastUsername();

        return $this->render('@Viazushki/Security/login.html.twig', [
            'loginForm' => $loginForm->createView(),
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    public function registerAction(Request $request)
    {
        $user = new User();
        $registerForm = $this->createForm(RegisterType::class, $user);

        $registerForm->handleRequest($request);
        if ($registerForm->isSubmitted() && $registerForm->isValid()) {

            $user = new User();
            $user->setUsername($registerForm->get('username')->getData());
            $user->setEmail($registerForm->get('email')->getData());
            $user->setPassword($this->encodePassword($user, $registerForm->get('password')->getData()));
            $user->setRoles(['ROLE_USER']);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('viazushki_homepage');
        }

        return $this->render('@Viazushki/Security/register.html.twig', [
            'registerForm' => $registerForm->createView(),
        ]);
    }

    private function encodePassword(User $user, $plainPassword)
    {
        $encoder = $this->container->get('security.encoder_factory')
            ->getEncoder($user)
        ;

        return $encoder->encodePassword($plainPassword, $user);
    }
}

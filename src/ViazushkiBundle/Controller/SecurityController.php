<?php

namespace ViazushkiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ViazushkiBundle\Entity\User;
use ViazushkiBundle\Form\Type\LoginType;

class SecurityController extends Controller
{
    public function loginAction()
    {
        $authUtils = $this->get('security.authentication_utils');

        $user = new User();
        $loginForm = $this->createForm(LoginType::class, $user);

        $error = $authUtils->getLastAuthenticationError();
        $lastUsername = $authUtils->getLastUsername();

        return $this->render('@Viazushki/Security/login.html.twig', array(
            'loginForm' => $loginForm->createView(),
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }
}
<?php

namespace ViazushkiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use ViazushkiBundle\Emails\SendForgotPasswordEmail;
use ViazushkiBundle\Entity\User;
use ViazushkiBundle\Form\Type\ChangePasswordType;
use ViazushkiBundle\Form\Type\EmailsType;
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

            $request->getSession()
                ->getFlashBag()
                ->add('success_register', 'Добро пожаловать '.$registerForm->get('username')->getData().'!')
            ;

            $user = new User();
            $user->setUsername($registerForm->get('username')->getData());
            $user->setEmail($registerForm->get('email')->getData());
            $user->setPassword($this->encodePassword($user, $registerForm->get('plainPassword')->getData()));
            $user->setRoles(['ROLE_USER']);

            $this->authenticateUser($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('viazushki_homepage');
        }

        return $this->render('@Viazushki/Security/register.html.twig', [
            'registerForm' => $registerForm->createView(),
        ]);
    }

    public function resetPasswordAction(Request $request)
    {
        $form = $this->createForm(EmailsType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->findOneBy([
               'email' => $form->get('email')->getData(),
            ]);

            if (!$user) {
                return new Response('Произошла ошибка в отправке сообщения!', 404);
            }

            $forgotKey = md5($user->getSalt() . $user->getEmail());

            $user->setForgotPasswordKey($forgotKey);
            $em->flush();

            $sendForgotPasswordEmail = $this->get('viazushki.send_forgot_password_email');

            if ($sendForgotPasswordEmail->send($user, 'Восстановление пароля', $forgotKey)) {
                return new Response('На Вашу почту отправлено сообщение.');
            } else {
                return new Response('Произошла ошибка в отправке сообщения!', 404);
            }
        }

        return $this->render('@Viazushki/Security/resetPassword.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function forgotPasswordAction(Request $request, $forgotKey)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->findOneBy([
           'forgotPasswordKey' => $forgotKey,
        ]);

        if (!$user) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(ChangePasswordType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($this->encodePassword($user, $form->get('plainPassword')->getData()));
            $em->flush();

            return new Response('Пароль успешно изменен.');
        }

        return $this->render('@Viazushki/Security/changePassword.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function encodePassword(User $user, $plainPassword)
    {
        $encoder = $this->container->get('security.encoder_factory')
            ->getEncoder($user)
        ;

        return $encoder->encodePassword($plainPassword, $user);
    }

    private function authenticateUser(User $user)
    {
        $providerKey = 'secured_area';
        $token = new UsernamePasswordToken($user, null, $providerKey, $user->getRoles());

        $this->container->get('security.token_storage')->setToken($token);
    }
}

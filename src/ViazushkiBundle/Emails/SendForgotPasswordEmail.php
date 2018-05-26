<?php

namespace ViazushkiBundle\Emails;

use ViazushkiBundle\Entity\User;

class SendForgotPasswordEmail
{
    private $sendEmail;
    private $templating;
    private $viazushkiEmail;

    public function __construct(\Twig_Environment $templating, $viazushkiEmail, SendEmail $sendEmail)
    {
        $this->sendEmail = $sendEmail;
        $this->viazushkiEmail = $viazushkiEmail;
        $this->templating = $templating;
    }

    /**
     * @param User $user
     * @param string $subject
     * @param string $forgotKey
     *
     * @return bool
     */
    public function send(User $user, string $subject, string $forgotKey)
    {
        return $this->sendEmail->send(
            $subject,
            $this->viazushkiEmail,
            $user->getEmail(),
            $this->templating->render('@Viazushki/Email/forgotPassword.html.twig', [
                'forgotKey' => $forgotKey,
            ])
        );
    }
}

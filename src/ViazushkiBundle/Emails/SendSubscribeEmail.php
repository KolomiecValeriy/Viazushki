<?php

namespace ViazushkiBundle\Emails;

use ViazushkiBundle\Entity\User;

class SendSubscribeEmail
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
     *
     * @return bool
     */
    public function sendSubscribe(User $user, string $subject)
    {
        return $this->sendEmail->send(
            $subject,
            $this->viazushkiEmail,
            $user->getEmail(),
            $this->templating->render('@Viazushki/Email/subscribe.html.twig', [
                'unsubscribeKey' => $user->getUnsubscribeKey(),
            ])
        );
    }
}

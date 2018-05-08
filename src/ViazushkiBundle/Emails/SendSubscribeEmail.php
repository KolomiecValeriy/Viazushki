<?php

namespace ViazushkiBundle\Emails;

use Twig_Environment;
use ViazushkiBundle\Entity\User;

class SendSubscribeEmail
{
    /**
     * @var SendEmail
     */
    private $sendEmail;

    /**
     * @var Twig_Environment
     */
    private $templating;

    /**
     * @var string
     */
    private $viazushkiEmail;

    public function __construct(\Twig_Environment $templating, $viazushkiEmail, SendEmail $sendEmail)
    {
        $this->sendEmail = $sendEmail;
        $this->viazushkiEmail = $viazushkiEmail;
        $this->templating = $templating;
    }

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

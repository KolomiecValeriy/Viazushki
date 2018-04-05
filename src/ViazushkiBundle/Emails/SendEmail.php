<?php

namespace ViazushkiBundle\Emails;


class SendEmail
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send(string $subject, string $emailFrom, string $emailTo, string $body, string $contentType = 'text/html')
    {
        if (!$subject || !$emailFrom || !$emailTo || !$body) {
            return false;
        }

        $message = new \Swift_Message();

        $message->setContentType($contentType);
        $message->setSubject($subject);
        $message->setFrom($emailFrom);
        $message->setTo($emailTo);
        $message->setBody($body);

        $this->mailer->send($message);

        return true;
    }
}

<?php

namespace ViazushkiBundle\Service;


class SendingMessage
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $body;

    /**
     * @var string
     */
    private $viazushkiEmail;

    /**
     * @var string
     */
    private $viazuskiContactEmailSubject;

    public function __construct($viazushkiEmail, $viazuskiContactEmailSubject, \Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
        $this->viazushkiEmail = $viazushkiEmail;
        $this->viazuskiContactEmailSubject = $viazuskiContactEmailSubject;
    }

    /**
     * Sending message
     */
    public function send()
    {
        $message = new \Swift_Message();
        $message->setContentType('text/html');
        $message->setSubject($this->getViazuskiContactEmailSubject());
        $message->setFrom($this->getviazushkiEmail());
        $message->setTo($this->getEmail());
        $message->setBody($this->getBody());

        $this->mailer->send($message);

        return true;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return string
     */
    public function getviazushkiEmail()
    {
        return $this->viazushkiEmail;
    }

    /**
     * @param string $viazushkiEmail
     */
    public function setviazushkiEmail($viazushkiEmail)
    {
        $this->viazushkiEmail = $viazushkiEmail;
    }

    /**
     * @return string
     */
    public function getViazuskiContactEmailSubject()
    {
        return $this->viazuskiContactEmailSubject;
    }

    /**
     * @param string $viazuskiContactEmailSubject
     */
    public function setViazuskiContactEmailSubject($viazuskiContactEmailSubject)
    {
        $this->viazuskiContactEmailSubject = $viazuskiContactEmailSubject;
    }
}

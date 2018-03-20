<?php

namespace ViazushkiBundle\Service;

use Doctrine\ORM\EntityManager;
use Twig_Environment;
use ViazushkiBundle\Entity\User;

class SendSubscribeEmail
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var Twig_Environment
     */
    private $templating;

    /**
     * @var string
     */
    private $viazushkiEmail;

    public function __construct(\Swift_Mailer $mailer, EntityManager $entityManager, \Twig_Environment $templating, $viazushkiEmail)
    {
        $this->mailer = $mailer;
        $this->em = $entityManager;
        $this->viazushkiEmail = $viazushkiEmail;
        $this->templating = $templating;
    }

    public function sendNews(string $subject)
    {
        $subscribeUsers = $this->em->getRepository('ViazushkiBundle:User')->findSubscribeUsers();
        $date = new \DateTime('-1 day');
        $newToys = $this->em->getRepository('ViazushkiBundle:Toy')->findNewToys($date->format('Y-m-d'));

        if (!$subscribeUsers) {
            return false;
        }

        $message = new \Swift_Message();

        $template = $this->templating->render('@Viazushki/Email/newToys.html.twig', [
            'newToys' => $newToys,
        ]);

        foreach ($subscribeUsers as $user) {
            $message->setContentType('text/html');
            $message->setSubject($subject);
            $message->setFrom($this->viazushkiEmail);
            $message->setTo($user->getEmail());
            $message->setBody($template);

            $this->mailer->send($message);
        }

        return true;
    }

    public function sendSubscribe(User $user, string $subject)
    {
        $message = new \Swift_Message();

        $message->setContentType('text/html');
        $message->setSubject($subject);
        $message->setFrom($this->viazushkiEmail);
        $message->setTo($user->getEmail());
        $message->setBody($this->templating->render('@Viazushki/Email/subscribe.html.twig'));

        $this->mailer->send($message);

        return true;
    }
}

<?php

namespace ViazushkiBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ViazushkiBundle\Service\SendSubscribeEmail;

class SendNewsEmailCommand extends Command
{
    private $sendSubscribeEmail;

    public function __construct(SendSubscribeEmail $sendSubscribeEmail)
    {
        $this->sendSubscribeEmail = $sendSubscribeEmail;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('viazushki:email:send-news')
            ->setDescription('Sending news email.')
            ->setHelp('Sending news email according to user subscriptions.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Starting send emails...',
            '=======================',
            '',
        ]);

        $output->writeln([
            'Sending...',
            '',
        ]);

        if (!$this->sendSubscribeEmail->sendNews('We have new toys2')) {
            $output->writeln([
                'Error'
            ]);
        } else {
            $output->writeln([
                'Sending done!',
            ]);
        }
    }

}

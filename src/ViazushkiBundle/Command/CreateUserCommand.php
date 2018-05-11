<?php

namespace ViazushkiBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use ViazushkiBundle\User\UserCreator;

class CreateUserCommand extends Command
{
    private $userCreator;

    public function __construct(UserCreator $userCreator)
    {
        $this->userCreator = $userCreator;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('viazushki:user:create')
            ->setDescription('Creating user.')
            ->setHelp('Creating new user. May be only one user with name - admin')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $output->writeln([
            '',
            '<info>Creating new user</info>',
            '=================',
            '',
        ]);

        $question = new Question('Please enter the username:');
        $userName = $helper->ask($input, $output, $question);

        $question = new Question('Please enter the password:');
        $question->setValidator(function ($value) {
            if (trim($value) == '') {
                throw new \Exception('The password cannot be empty');
            }

            if (strlen($value) < 6) {
                throw new \Exception('Password mast contain more than 5 symbols!');
            }

            return $value;
        });
        $question->setHidden(true);
        $question->setMaxAttempts(3);
        $password = $helper->ask($input, $output, $question);

        $question = new Question('Please confirm the password:');
        $question->setValidator(function ($value) {
            if (trim($value) == '') {
                throw new \Exception('The password confirm cannot be empty');
            }

            return $value;
        });
        $question->setHidden(true);
        $question->setMaxAttempts(3);
        $passwordConfirm = $helper->ask($input, $output, $question);

        $question = new Question('Please enter the email:');
        $question->setValidator(function ($value) {
            if (trim($value) == '') {
                throw new \Exception('The email cannot be empty');
            }

            return $value;
        });
        $question->setMaxAttempts(3);
        $email = $helper->ask($input, $output, $question);
        $output->writeln('');

        $table = new Table($output);
        $table
            ->setHeaders([
                'Username',
                'Email',
            ])
            ->setRows([
                [
                    $userName,
                    $email,
                ],
            ])
        ;

        if ($password == $passwordConfirm) {
            if ($this->userCreator->create($userName, $password, $email)) {
                $table->render();
                $output->writeln('');
                $output->writeln('<info>User - ' . $userName . ', successfully created.</info>');
            } else {
                $output->writeln('<error>May be only one user with name - admin</error>');
            }
        } else {
            $output->writeln('<error>Passwords do not match!</error>');
        }

    }
}

<?php

namespace ViazushkiBundle\DataFixtures\ORM;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use ViazushkiBundle\Entity\User;

class UserFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user
            ->setUsername('admin')
            ->setEmail('admin@gmail.com')
            ->setPassword('111')
            ->setIsActive(true)
            ->setRoles('ADMIN')
        ;

        $manager->persist($user);

        for ($i = 1; $i <= 10; $i++) {
            $user = new User();
            $user
                ->setUsername('user'.$i)
                ->setEmail('user'.$i.'@gmail.com')
                ->setPassword('123')
                ->setIsActive(true)
                ->setRoles('USER')
            ;

            $manager->persist($user);
        }

        $manager->flush();
    }
}
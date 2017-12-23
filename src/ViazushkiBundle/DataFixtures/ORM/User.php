<?php

namespace ViazushkiBundle\DataFixtures\ORM;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use ViazushkiBundle\Entity\User;

class UserFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $admin = new User();
        $admin
            ->setUsername('admin')
            ->setEmail('admin@gmail.com')
            ->setPassword('admin')
            ->setIsActive(true)
            ->setRoles(['ROLE_ADMIN'])
        ;
        $manager->persist($admin);

        $userManager = new User();
        $userManager
            ->setUsername('manager')
            ->setEmail('manager@gmail.com')
            ->setPassword('manager')
            ->setIsActive(true)
            ->setRoles(['ROLE_MANAGER'])
        ;
        $manager->persist($userManager);

        for ($i = 1; $i <= 10; $i++) {
            $user = new User();
            $user
                ->setUsername('user'.$i)
                ->setEmail('user'.$i.'@gmail.com')
                ->setPassword('user'.$i)
                ->setRoles(['ROLE_USER'])
            ;

            $manager->persist($user);
        }

        $manager->flush();
    }
}
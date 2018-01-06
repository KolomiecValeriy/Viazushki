<?php

namespace ViazushkiBundle\DataFixtures\ORM;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use ViazushkiBundle\Entity\User;

class UserFixtures extends Fixture implements ContainerAwareInterface
{
    protected $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $factory = $this->container->get('security.encoder_factory');

        $admin = new User();

        $encoder = $factory->getEncoder($admin);
        $admin
            ->setUsername('superAdmin')
            ->setEmail('superAdmin@gmail.com')
            ->setPassword($encoder->encodePassword('superAdmin', $admin))
            ->setIsActive(true)
            ->setRoles(['ROLE_SUPER_ADMIN'])
        ;
        $manager->persist($admin);

        $userManager = new User();
        $userManager
            ->setUsername('admin')
            ->setEmail('admin@gmail.com')
            ->setPassword($encoder->encodePassword('admin', $userManager))
            ->setIsActive(true)
            ->setRoles(['ROLE_ADMIN'])
        ;
        $manager->persist($userManager);

        for ($i = 1; $i <= 10; $i++) {
            $user = new User();
            $user
                ->setUsername('user'.$i)
                ->setEmail( 'user'.$i.'@gmail.com')
                ->setPassword($encoder->encodePassword('user'.$i, $user))
                ->setRoles(['ROLE_USER'])
            ;

            $manager->persist($user);
        }

        $manager->flush();
    }
}
<?php

namespace ViazushkiBundle\DataFixtures\ORM;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Validator\Exception\ValidatorException;
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
        $validator = $this->container->get('validator');

        $admin = new User();

        $encoder = $factory->getEncoder($admin);
        $password = $encoder->encodePassword('11111111', $admin);
        $admin
            ->setUsername('superAdmin')
            ->setEmail('super.admin@example.com')
            ->setPassword($password)
            ->setPlainPassword($password)
            ->setIsActive(true)
            ->setRoles(['ROLE_SUPER_ADMIN'])
            ->setSubscribe(false)
        ;

        $violations = $validator->validate($admin);
        if (count($violations) > 0) {
            throw new ValidatorException($violations->get(0)->getMessage());
        }
        $manager->persist($admin);

        $userManager = new User();
        $password = $encoder->encodePassword('22222222', $userManager);
        $userManager
            ->setUsername('admin')
            ->setEmail('admin@example.com')
            ->setPassword($password)
            ->setPlainPassword($password)
            ->setIsActive(true)
            ->setRoles(['ROLE_ADMIN'])
            ->setSubscribe(false)
        ;

        $violations = $validator->validate($userManager);
        if (count($violations) > 0) {
            throw new ValidatorException($violations->get(0)->getMessage());
        }
        $manager->persist($userManager);

        for ($i = 1; $i <= 10; $i++) {
            $user = new User();
            $password = $encoder->encodePassword('22222222', $user);
            $user
                ->setUsername('user'.$i)
                ->setEmail( 'user.'.$i.'@example.com')
                ->setPassword($password)
                ->setPlainPassword($password)
                ->setIsActive(true)
                ->setRoles(['ROLE_USER'])
                ->setSubscribe(false)
            ;

            $violations = $validator->validate($user);
            if (count($violations) > 0) {
                throw new ValidatorException($violations->get(0)->getMessage());
            }
            $manager->persist($user);
            $this->setReference('user'.$i, $user);
        }

        $manager->flush();
    }
}
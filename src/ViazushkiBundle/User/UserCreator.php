<?php

namespace ViazushkiBundle\User;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use ViazushkiBundle\Entity\User;

class UserCreator
{
    private $entityManager;
    private $factory;
    private $validator;

    public function __construct(EntityManager $entityManager, EncoderFactory $factory, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->factory = $factory;
        $this->validator = $validator;
    }

    /**
     * @param string $userName
     * @param string $password
     * @param string $email
     * @return bool
     */
    public function create($userName, $password, $email)
    {
        $userAdmin = 'admin';
        $userRepository = $this->entityManager->getRepository(User::class);

        if ($user = $userRepository->findOneBy(['username' => $userName])) {
            if ($user->getUsername() == $userAdmin) {
                return false;
            }
        }

        $role = 'ROLE_USER';
        if ($userName == $userAdmin) {
            $role = 'ROLE_SUPER_ADMIN';
        }

        $user = new User();
        $encoder = $this->factory->getEncoder($user);

        $password = $encoder->encodePassword($password, $user->getSalt());
        $user
            ->setUsername($userName)
            ->setEmail($email)
            ->setPassword($password)
            ->setPlainPassword($password)
            ->setIsActive(true)
            ->setRoles([$role])
            ->setSubscribe(false)
        ;

        $violations = $this->validator->validate($user);

        if (count($violations) > 0) {
            throw new ValidatorException($violations->get(0)->getMessage());
        }

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return true;
    }
}

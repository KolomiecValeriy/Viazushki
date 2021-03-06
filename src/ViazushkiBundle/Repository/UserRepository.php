<?php

namespace ViazushkiBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserRepository extends EntityRepository implements UserLoaderInterface
{
    public function loadUserByUsername($username)
    {
        return $this->createQueryBuilder('u')
            ->where('u.username = :username OR u.email = :email')
            ->setParameter('username', $username)
            ->setParameter('email', $username)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findSubscribeUsers()
    {
        return $this->createQueryBuilder('u')
            ->where('u.subscribe = true')
            ->getQuery()
        ;
    }

    public function finUserByUnsubscribeKey($unsubscribeKey)
    {
        return $this->createQueryBuilder('u')
            ->where('u.unsubscribeKey = :unsubscribeKey')
            ->setParameter('unsubscribeKey', $unsubscribeKey)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}

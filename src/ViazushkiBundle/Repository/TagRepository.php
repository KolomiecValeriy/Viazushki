<?php

namespace ViazushkiBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TagRepository extends EntityRepository
{
    public function findBySlug($slug)
    {
        $query = $this->createQueryBuilder('tg')
            ->where('tg.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery()
        ;

        return $query->getResult();
    }
}

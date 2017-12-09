<?php

namespace ViazushkiBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CategoryRepository extends EntityRepository
{
    public function findBySlug($slug)
    {
        $query = $this->createQueryBuilder('c')
            ->where('c.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery()
        ;

        return $query->getResult();
    }
}

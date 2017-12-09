<?php

namespace ViazushkiBundle\Repository;

use Doctrine\ORM\EntityRepository;
use ViazushkiBundle\Entity\Category;
use ViazushkiBundle\Entity\Tag;

class ToyRepository extends EntityRepository
{
    public function findLastAdded($limit)
    {
        $query = $this->createQueryBuilder('t')
            ->orderBy('t.createdAt', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
        ;

        return $query->getResult();
    }

    public function findByTag(Tag $tag)
    {
        $query = $this->createQueryBuilder('t')
            ->leftJoin('t.tags', 'tg')
            ->where('tg.id = :tag')
            ->setParameter('tag', $tag)
            ->getQuery()
        ;

        return $query->getResult();
    }

    public function findByCategory(Category $category)
    {
        $query = $this->createQueryBuilder('t')
            ->leftJoin('t.category', 'tc')
            ->where('tc.id = :category')
            ->setParameter('category', $category)
            ->getQuery()
        ;

        return $query->getResult();
    }
}

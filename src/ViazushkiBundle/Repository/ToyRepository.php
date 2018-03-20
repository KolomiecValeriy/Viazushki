<?php

namespace ViazushkiBundle\Repository;

use Doctrine\ORM\EntityRepository;
use ViazushkiBundle\Entity\Category;
use ViazushkiBundle\Entity\Tag;

class ToyRepository extends EntityRepository
{
    public function findAllQuery()
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.updatedAt', 'DESC')
            ->getQuery()
        ;
    }

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

        return $query;
    }

    public function findByCategory(Category $category)
    {
        $query = $this->createQueryBuilder('t')
            ->leftJoin('t.category', 'tc')
            ->where('tc.id = :category')
            ->setParameter('category', $category)
            ->getQuery()
        ;

        return $query;
    }

    public function findByText($searchText)
    {
        $query = $this->createQueryBuilder('t')
            ->where('t.name LIKE :searchText')
            ->orWhere('t.description LIKE :searchText')
            ->setParameter('searchText', '%'.$searchText.'%')
            ->getQuery()
        ;

        return $query;
    }

    public function findNewToys($date)
    {
        $query = $this->createQueryBuilder('t')
            ->where('t.createdAt > :date')
            ->setParameter('date', $date)
            ->getQuery()
        ;

        return $query->getResult();
    }
}

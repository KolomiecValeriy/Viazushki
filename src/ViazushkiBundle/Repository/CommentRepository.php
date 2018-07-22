<?php

namespace ViazushkiBundle\Repository;

use Gedmo\Tree\Entity\Repository\NestedTreeRepository;
use ViazushkiBundle\Entity\Toy;

class CommentRepository extends NestedTreeRepository
{
    public function finByToyQuery(Toy $toy)
    {
        return $this->createQueryBuilder('c')
            ->where('c.toy = :toy')
            ->andWhere('c.lvl = :lvl')
            ->setParameter('toy', $toy)
            ->setParameter('lvl', 0)
            ->orderBy('c.createdAt', 'DESC')
            ->getQuery()
            ;
    }
}

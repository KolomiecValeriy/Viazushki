<?php

namespace ViazushkiBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use ViazushkiBundle\Entity\Comment;

class CommentFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {

        for ($i = 1; $i <= 50; $i++) {

            $toy = rand(1, 10);
            $userRand1 = rand(1, 10);

            $comment = new Comment();
            $comment
                ->setMessage('Комментарий '.$i)
                ->setToy($this->getReference('toy'.$toy))
                ->setUser($this->getReference('user'.$userRand1))
            ;

            $countRand = rand(1, 4);
            for ($j = 1; $j <= $countRand; $j++) {

                $userRand2 = rand(1, 10);

                $commentChild = new Comment();
                $commentChild
                    ->setMessage('Ответ '.$j)
                    ->setParent($comment)
                    ->setToy($this->getReference('toy'.$toy))
                    ->setUser($this->getReference('user'.$userRand2))
                ;
                $manager->persist($commentChild);
            }
            $manager->persist($comment);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
          ToyFixtures::class,
          UserFixtures::class,
        ];
    }
}
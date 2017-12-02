<?php

namespace ViazushkiBundle\DataFixtures\ORM;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use ViazushkiBundle\Entity\Toy;

class ToyFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $defaultToy = [
            'name' => 'Игрушка',
            'author' => 'Админ',
            'description' => 'Мягкие плюшевые игрушки станут лучшими друзьями для ваших деток. 
                Прекрасный вариант для подарка на выписку, день рождения, Новый год.
                Можно сделать наборчик ( игрушка + пинетки,повязка на голову, шапочка, свитерок, варежки для новорожденных).',
        ];

        for ($i = 1, $j = 1; $i <= 10; $i++, $j++) {

            if ($j > 5) $j = 1;

            $toy = new Toy();
            $toy->setName($defaultToy['name'].' '.$i)
                ->setAuthor($defaultToy['author'])
                ->setDescription($defaultToy['description'])
                ->setCategory($this->getReference('category'.$j))
                ->addTag($this->getReference('tag'.$j));

            $manager->persist($toy);
            $manager->flush();
        }
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
            TagFixtures::class,
        ];
    }
}
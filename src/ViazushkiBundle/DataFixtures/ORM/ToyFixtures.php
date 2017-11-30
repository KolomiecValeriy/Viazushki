<?php

namespace ViazushkiBundle\DataFixtures\ORM;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use ViazushkiBundle\Entity\Toy;

class ToyFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $toy = new Toy();
        $toy->setName('Toy 1');
        $toy->setAuthor('Author');
        $toy->setDescription('Some description');
        $toy->setCategory($this->getReference('category'));
        $toy->addTags($this->getReference('tag'));

        $manager->persist($toy);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
            TagFixtures::class,
        ];
    }
}
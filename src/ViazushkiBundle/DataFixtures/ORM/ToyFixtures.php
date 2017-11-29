<?php

namespace ViazushkiBundle\DataFixtures\ORM;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use ViazushkiBundle\Entity\Toy;

class ToyFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $categoryRepository = $manager->getRepository('ViazushkiBundle:Category');
        $category = $categoryRepository->find(1);


        $toy = new Toy();
        $toy->setName('Toy 1');
        $toy->setAuthor('Author');
        $toy->setDescription('Some description');
        $toy->setCategory($category);

        $manager->persist($toy);
        $manager->flush();
    }
}
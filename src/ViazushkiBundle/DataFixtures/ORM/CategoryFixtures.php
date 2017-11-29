<?php

namespace ViazushkiBundle\DataFixtures\ORM;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use ViazushkiBundle\Entity\Category;

class CategoryFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $category = new Category();
        $category->setName('Category 1');

        $manager->persist($category);
        $manager->flush();
    }
}
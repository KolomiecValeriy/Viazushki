<?php

namespace ViazushkiBundle\DataFixtures\ORM;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use ViazushkiBundle\Entity\Category;

class CategoryFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 5; $i++) {
            $category = new Category();
            $category->setName('Категория'.$i);

            $manager->persist($category);
            $manager->flush();

            $this->addReference('category'.$i, $category);
        }
    }
}
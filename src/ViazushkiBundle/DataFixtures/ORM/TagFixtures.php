<?php

namespace ViazushkiBundle\DataFixtures\ORM;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use ViazushkiBundle\Entity\Tag;

class TagFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 10; $i++) {
            $tag = new Tag();
            $tag->setName('Тег '.$i);

            $manager->persist($tag);

            $this->addReference('tag'.$i, $tag);
        }

        $manager->flush();
    }
}
<?php

namespace ViazushkiBundle\DataFixtures\ORM;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use ViazushkiBundle\Entity\Tag;

class TagFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $tag = new Tag();
        $tag->setName('Тег 1');

        $manager->persist($tag);
        $manager->flush();

        $this->addReference('tag', $tag);
    }
}
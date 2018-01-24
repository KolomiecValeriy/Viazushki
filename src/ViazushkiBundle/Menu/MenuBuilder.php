<?php

namespace ViazushkiBundle\Menu;

use Knp\Menu\FactoryInterface;

class MenuBuilder
{
    private $factory;

    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function createMainMenu()
    {
        $menu = $this->factory->createItem('root');

        $menu->setChildrenAttribute('class', 'nav navbar-nav');
        $menu->addChild('home', ['route' => 'viazushki_homepage']);
        $menu->addChild('contacts', ['route' => 'viazushki_contacts']);

        return $menu;
    }
}
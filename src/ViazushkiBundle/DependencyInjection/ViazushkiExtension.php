<?php

namespace ViazushkiBundle\DependencyInjection;


use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

class ViazushkiExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('viazushki.comments_edit_time', $config['comments']['edit_time']);
        $container->setParameter('viazushki.comments_per_page', $config['comments']['per_page']);
        $container->setParameter('viazushki.last_added_toys', $config['toys']['last_added']);
        $container->setParameter('viazushki.toys_per_page', $config['toys']['per_page']);
    }
}

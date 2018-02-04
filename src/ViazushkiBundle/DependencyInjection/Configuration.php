<?php

namespace ViazushkiBundle\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('viazushki');

        $rootNode
            ->children()
                ->arrayNode('comments')
                    ->children()
                        ->integerNode('edit_time')
                            ->defaultValue(3600)
                            ->min(900)
                        ->end()
                    ->end()
                ->end() //comments
            ->end()
        ;

        return $treeBuilder;
    }
}

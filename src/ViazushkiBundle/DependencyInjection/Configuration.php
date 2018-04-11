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
                        ->integerNode('per_page')
                            ->defaultValue(5)
                            ->min(5)
                        ->end()
                    ->end()
                ->end() //comments

                ->arrayNode('toys')
                    ->children()
                        ->integerNode('per_page')
                            ->defaultValue(5)
                            ->min(5)
                        ->end()
                        ->integerNode('last_added')
                            ->defaultValue(4)
                            ->min(4)
                        ->end()
                    ->end()
                ->end() //toys

                ->arrayNode('header')
                    ->children()
                        ->scalarNode('name')->end()
                        ->scalarNode('value')->end()
                    ->end()
                ->end() //header

                ->scalarNode('email')->end()
            ->end()
        ;

        return $treeBuilder;
    }
}

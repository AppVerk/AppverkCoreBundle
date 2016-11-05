<?php

namespace Cube\CoreBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('cube_core');

        $rootNode
            ->children()
                ->arrayNode('views')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('block_login')
                            ->defaultValue('CubeCoreBundle:blocks:login.html.twig')
                        ->end()
                        ->scalarNode('block_register')
                            ->defaultValue('CubeCoreBundle:blocks:register.html.twig')
                        ->end()
                        ->scalarNode('login')
                            ->defaultValue('CubeCoreBundle:Security:login.html.twig')
                        ->end()
                        ->scalarNode('profile')
                            ->defaultValue('CubeCoreBundle:User:profile.html.twig')
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}

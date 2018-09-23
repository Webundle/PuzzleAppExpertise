<?php

namespace Puzzle\App\ExpertiseBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('puzzle_app_expertise');

        $rootNode
            ->children()
                ->scalarNode('title')->defaultValue('expertise.title')->end()
                ->scalarNode('description')->defaultValue('expertise.description')->end()
                ->scalarNode('icon')->defaultValue('expertise.icon')->end()
                ->arrayNode('templates')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('service')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('list')->defaultValue('PuzzleAppExpertiseBundle:Service:list.html.twig')->end()
                                ->scalarNode('show')->defaultValue('PuzzleAppExpertiseBundle:Service:show.html.twig')->end()
                            ->end()
                        ->end()
                        ->arrayNode('project')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('list')->defaultValue('PuzzleAppExpertiseBundle:Project:list.html.twig')->end()
                                ->scalarNode('show')->defaultValue('PuzzleAppExpertiseBundle:Project:show.html.twig')->end()
                            ->end()
                        ->end()
                        ->arrayNode('staff')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('list')->defaultValue('PuzzleAppExpertiseBundle:Staff:list.html.twig')->end()
                                ->scalarNode('show')->defaultValue('PuzzleAppExpertiseBundle:Staff:show.html.twig')->end()
                            ->end()
                        ->end()
                        ->arrayNode('partner')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('list')->defaultValue('PuzzleAppExpertiseBundle:Partner:list.html.twig')->end()
                            ->end()
                        ->end()
                        ->arrayNode('testimonial')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('list')->defaultValue('PuzzleAppExpertiseBundle:Testimonial:list.html.twig')->end()
                                ->scalarNode('show')->defaultValue('PuzzleAppExpertiseBundle:Testimonial:show.html.twig')->end()
                            ->end()
                        ->end()
                        ->arrayNode('faq')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('list')->defaultValue('PuzzleAppExpertiseBundle:Faq:list.html.twig')->end()
                                ->scalarNode('show')->defaultValue('PuzzleAppExpertiseBundle:Faq:show.html.twig')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}

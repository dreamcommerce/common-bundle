<?php

/*
 * (c) 2017 DreamCommerce
 *
 * @package DreamCommerce\Component\Common
 * @author Michał Korus <michal.korus@dreamcommerce.com>
 * @link https://www.dreamcommerce.com
 */

declare(strict_types=1);

namespace DreamCommerce\Bundle\CommonBundle\DependencyInjection;

use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use Symfony\Component\Config\Definition\Builder\NodeBuilder;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    protected $supportedDrivers = array(
        SyliusResourceBundle::DRIVER_DOCTRINE_ORM
    );
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $rootNode = $treeBuilder
            ->root('dream_commerce')
                ->addDefaultsIfNotSet()
                ->children();
        ;

        $this->addJmsSection($rootNode);

        return $treeBuilder;
    }

    private function addJmsSection(NodeBuilder $builder)
    {
        $builder
            ->arrayNode('jms')
                ->addDefaultsIfNotSet()
                ->children()
                    ->arrayNode('handlers')
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->arrayNode('date')
                                ->addDefaultsIfNotSet()
                                ->children()
                                    ->scalarNode('default_format')->defaultValue('Y-m-d')->end()
                                    ->scalarNode('default_timezone')->defaultValue(date_default_timezone_get())->end()
                                    ->scalarNode('cdata')->defaultTrue()->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}

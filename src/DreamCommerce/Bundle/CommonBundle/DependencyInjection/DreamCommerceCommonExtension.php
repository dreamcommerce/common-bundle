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

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

final class DreamCommerceCommonExtension extends Extension
{
    const ALIAS = 'dream_commerce_common';

    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $config = $this->processConfiguration($this->getConfiguration($config, $container), $config);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $container->getDefinition('dream_commerce.jms.serializer.date_handler')
            ->addArgument($config['jms']['handlers']['date']['default_format'])
            ->addArgument($config['jms']['handlers']['date']['default_timezone'])
            ->addArgument($config['jms']['handlers']['date']['cdata'])
        ;
    }

    public function getAlias()
    {
        return self::ALIAS;
    }
}

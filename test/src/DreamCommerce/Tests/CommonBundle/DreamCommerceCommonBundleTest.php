<?php

/*
 * (c) 2017 DreamCommerce
 *
 * @package DreamCommerce\Component\Common
 * @author Michał Korus <michal.korus@dreamcommerce.com>
 * @link https://www.dreamcommerce.com
 */

namespace DreamCommerce\Tests\CommonBundle;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class DreamCommerceCommonBundleTest extends WebTestCase
{
    /**
     * @test
     */
    public function its_services_are_intitializable()
    {
        /** @var ContainerInterface $container */
        $container = self::createClient()->getContainer();

        $services = $container->getServiceIds();

        $services = array_filter($services, function ($serviceId) {
            return false !== strpos($serviceId, 'dream_commerce');
        });

        $this->assertTrue(count($services) > 0);

        foreach ($services as $id) {
            $container->get($id);
        }
    }
}

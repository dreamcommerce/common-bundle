<?php

/*
 * (c) 2017 DreamCommerce
 *
 * @package DreamCommerce\Component\Common
 * @author Michał Korus <michal.korus@dreamcommerce.com>
 * @link https://www.dreamcommerce.com
 */

namespace DreamCommerce\Bundle\CommonBundle;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Types\Type;
use DreamCommerce\Component\Common\Doctrine\DBAL\Types\UTCDateTimeType;
use DreamCommerce\Component\Common\Doctrine\DBAL\Types\UTCDateType;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class DreamCommerceCommonBundle extends Bundle
{
    public function boot()
    {
        /** @var Registry $registry */
        $registry = $this->container->get('doctrine', ContainerInterface::NULL_ON_INVALID_REFERENCE);

        if ($registry !== null) {
            /** @var Connection $connection */
            foreach ($registry->getConnections() as $connection) {
                $platform = $connection->getDatabasePlatform();

                $types = array(
                    UTCDateTimeType::TYPE_NAME => UTCDateTimeType::class,
                    UTCDateType::TYPE_NAME => UTCDateType::class
                );

                foreach ($types as $type => $className) {
                    if (!Type::hasType($type)) {
                        Type::addType($type, $className);
                        $platform->registerDoctrineTypeMapping($type, $type);
                    }
                }
            }
        }
    }
}

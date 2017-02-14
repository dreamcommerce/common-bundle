<?php

namespace DreamCommerce\Bundle\CommonBundle;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Types\Type;
use DreamCommerce\Component\Common\Doctrine\DBAL\Types\UTCDateTimeType;
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

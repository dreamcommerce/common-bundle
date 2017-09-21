<?php

/*
 * (c) 2017 DreamCommerce
 *
 * @package DreamCommerce\Component\Common
 * @author Michał Korus <michal.korus@dreamcommerce.com>
 * @link https://www.dreamcommerce.com
 */

namespace DreamCommerce\Component\Common\JMS\Serializer\Construction;

use Doctrine\Common\Persistence\ObjectManager;
use InvalidArgumentException;
use JMS\Serializer\Construction\ObjectConstructorInterface;
use JMS\Serializer\DeserializationContext;
use JMS\Serializer\Metadata\ClassMetadata;
use JMS\Serializer\VisitorInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Metadata\RegistryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SyliusConstructor implements ObjectConstructorInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var RegistryInterface
     */
    private $registry;

    /**
     * @var ObjectConstructorInterface
     */
    private $fallbackConstructor;

    /**
     * @param ContainerInterface $container
     * @param RegistryInterface $registry
     * @param ObjectConstructorInterface $fallbackConstructor
     */
    public function __construct(ContainerInterface $container, RegistryInterface $registry, ObjectConstructorInterface $fallbackConstructor)
    {
        $this->container = $container;
        $this->registry = $registry;
        $this->fallbackConstructor = $fallbackConstructor;
    }

    /**
     * {@inheritdoc}
     */
    public function construct(VisitorInterface $visitor, ClassMetadata $metadata, $data, array $type, DeserializationContext $context)
    {
        $syliusMetadata = null;
        try {
            $syliusMetadata = $this->registry->getByClass($metadata->name);
        } catch (InvalidArgumentException $exception) {
            // ignore
        }

        if ($syliusMetadata !== null) {
            $object = null;
            if (isset($data['id'])) {
                $repositoryId = $syliusMetadata->getServiceId('repository');
                /** @var RepositoryInterface $repository */
                $repository = $this->container->get($repositoryId);
                $object = $repository->find($data['id']);

                $managerId = $syliusMetadata->getServiceId('manager');
                /** @var ObjectManager $manager */
                $manager = $this->container->get($managerId);
                $manager->initializeObject($object);
            }

            if ($object === null) {
                $factoryId = $syliusMetadata->getServiceId('factory');
                /** @var FactoryInterface $factory */
                $factory = $this->container->get($factoryId);
                $object = $factory->createNew();
            }

            return $object;
        }

        return $this->fallbackConstructor->construct($visitor, $metadata, $data, $type, $context);
    }
}

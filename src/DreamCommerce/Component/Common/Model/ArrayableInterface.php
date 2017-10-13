<?php

/*
 * (c) 2017 DreamCommerce
 *
 * @package DreamCommerce\Component\Common
 * @author Michał Korus <michal.korus@dreamcommerce.com>
 * @link https://www.dreamcommerce.com
 */

declare(strict_types=1);

namespace DreamCommerce\Component\Common\Model;

use InvalidArgumentException;

interface ArrayableInterface
{
    /**
     * @param object|null $object
     *
     * @throws InvalidArgumentException
     *
     * @return array
     */
    public function toArray($object = null): array;

    /**
     * @param array       $data
     * @param object|null $object
     *
     * @throws InvalidArgumentException
     */
    public function fromArray(array $data, $object = null): void;

    /**
     * @return array
     */
    public function getIgnoredProperties(): array;
}

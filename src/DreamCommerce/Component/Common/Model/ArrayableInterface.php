<?php

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
    public function fromArray(array $data, $object = null);
}

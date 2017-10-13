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

use DreamCommerce\Component\Common\Exception\InvalidTypeException;
use Zend\Stdlib\SplPriorityQueue;

abstract class TypedSplPriorityQueue extends SplPriorityQueue
{
    /**
     * @var string
     */
    protected $expectedObjectType = null;

    public function insert($object, $priority)
    {
        if ($this->expectedObjectType === null) {
            throw InvalidTypeException::forUndefinedExpectedType();
        }

        if (!($object instanceof $this->expectedObjectType)) {
            $givenType = (is_object($object)) ? get_class($object) : gettype($object);
            throw InvalidTypeException::forUnexpectedType($givenType, $this->expectedObjectType);
        }


        parent::insert($object, $priority);
    }
}

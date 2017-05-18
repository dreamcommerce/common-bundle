<?php
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
<?php
namespace DreamCommerce\Component\Common\Model;


use DreamCommerce\Component\Common\Exception\InvalidTypeException;
use Zend\Stdlib\SplPriorityQueue;

abstract class TypedSplPriorityQueue extends SplPriorityQueue
{
    const INDEX_NAME   = 'name';
    const INDEX_OBJECT = 'object';

    /**
     * @var string
     */
    protected $expectedObjectType = null;

    public function insert(string $name, $object, int $priority)
    {
        if ($this->expectedObjectType === null) {
            throw InvalidTypeException::forUndefinedExpectedType();
        }

        if (!($object instanceof $this->expectedObjectType)) {
            $givenType = (is_object($object)) ? get_class($object) : gettype($object);
            throw InvalidTypeException::forUnexpectedType($givenType, $this->expectedObjectType);
        }

        $datum = [
            self::INDEX_NAME    => $name,
            self::INDEX_OBJECT  => $object
        ];

        parent::insert($datum, $priority);
    }
}
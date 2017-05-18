<?php
namespace DreamCommerce\Component\Common\Exception;

use Exception;
use Throwable;

class InvalidTypeException extends Exception implements ContextInterface
{
    use ContextTrait;

    /**
     * ERROR CODES
     */
    const INVALID_TYPE_FOR_QUEUE = 0xDEAD;

    /**
     * @var string
     */
    protected $givenType;

    /**
     * @var string
     */
    protected $expectedType;

    /**
     * @param string $given
     * @param string $expected
     * @param Throwable|null $previousException
     * @return InvalidTypeException
     */
    public static function forPriorityQueue(string $given, string $expected, Throwable $previousException = null): InvalidTypeException
    {
        $exception = new static(
            sprintf("Invalid type object set to priority queue. Expected %s, %s given.", $expected, $given),
            self::INVALID_TYPE_FOR_QUEUE,
            $previousException
        );

        $exception->givenType = $given;
        $exception->expectedType = $expected;

        return $exception;
    }

    /**
     * @return string
     */
    public function getGivenType(): string
    {
        return $this->givenType;
    }

    /**
     * @return string
     */
    public function getExpectedType(): string
    {
        return $this->expectedType;
    }
}
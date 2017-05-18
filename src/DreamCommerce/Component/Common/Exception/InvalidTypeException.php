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
    const INVALID_TYPE_FOR_QUEUE  = 0xDEAD;
    const UNDEFINED_EXPECTED_TYPE = 0xFEE;


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
    public static function forUnexpectedType(string $given, string $expected, Throwable $previousException = null): InvalidTypeException
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
     * When expected type is undefined.
     * @param Throwable|null $previousException
     * @return InvalidTypeException
     */
    public static function forUndefinedExpectedType(Throwable $previousException = null): InvalidTypeException
    {
        return new static("Undefined expected type.", self::UNDEFINED_EXPECTED_TYPE, $previousException);
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
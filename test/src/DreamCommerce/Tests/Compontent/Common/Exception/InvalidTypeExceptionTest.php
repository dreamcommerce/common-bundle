<?php
namespace DreamCommerce\Tests\Compontent\Common\Exception;


use DreamCommerce\Component\Common\Exception\InvalidTypeException;
use PHPUnit\Framework\TestCase;

class InvalidTypeExceptionTest extends TestCase
{
    /**
     * @dataProvider invalidTypeDataProvider
     */
    public function testForPriorityQueueException($given, $expected)
    {
        $exception = InvalidTypeException::forPriorityQueue($given, $expected);
        $this->assertInstanceOf(InvalidTypeException::class, $exception);
        $this->assertEquals($given,     $exception->getGivenType());
        $this->assertEquals($expected,  $exception->getExpectedType());
    }

    /**
     * @dataProvider invalidTypeDataProvider
     * @expectedException \DreamCommerce\Component\Common\Exception\InvalidTypeException
     * @expectedExceptionCode 57005
     * @expectedExceptionMessageRegExp /Expected [0-9a-z_\-]+, [0-9a-z_\-]+ given\./i
     */
    public function testThrowException($given, $expected)
    {
        throw InvalidTypeException::forPriorityQueue($given, $expected);
    }

    /**
     * @expectedException \DreamCommerce\Component\Common\Exception\InvalidTypeException
     * @expectedExceptionCode 4078
     * @expectedExceptionMessage Undefined expected type.
     */
    public function testUndefinedExpectedType()
    {
        throw InvalidTypeException::forUndefinedExpectedType();
    }

    public function invalidTypeDataProvider()
    {
        return [
            ['InvalidClassA', 'ExpectedClassB'],
            ['InvalidClassC', 'ExpectedClassD'],
            ['InvalidClassD', 'ExpectedClassE'],
            ['InvalidClassE', 'ExpectedClassF'],
            ['InvalidClassF', 'ExpectedClassG'],
        ];
    }
}
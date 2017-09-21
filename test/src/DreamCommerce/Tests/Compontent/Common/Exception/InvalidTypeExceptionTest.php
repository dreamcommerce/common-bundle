<?php

/*
 * (c) 2017 DreamCommerce
 *
 * @package DreamCommerce\Component\Common
 * @author Michał Korus <michal.korus@dreamcommerce.com>
 * @link https://www.dreamcommerce.com
 */

namespace DreamCommerce\Tests\Compontent\Common\Exception;

use DreamCommerce\Component\Common\Exception\InvalidTypeException;
use PHPUnit\Framework\TestCase;

class InvalidTypeExceptionTest extends TestCase
{
    /**
     * @dataProvider invalidTypeDataProvider
     */
    public function testForUnexpectedType($given, $expected)
    {
        $exception = InvalidTypeException::forUnexpectedType($given, $expected);
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
    public function testThrowExceptionForUnexpectedType($given, $expected)
    {
        throw InvalidTypeException::forUnexpectedType($given, $expected);
    }

    /**
     * @expectedException \DreamCommerce\Component\Common\Exception\InvalidTypeException
     * @expectedExceptionCode 4078
     * @expectedExceptionMessage Undefined expected type.
     */
    public function testThrowExceptionForUndefinedExpectedType()
    {
        throw InvalidTypeException::forUndefinedExpectedType();
    }

    public function invalidTypeDataProvider()
    {
        return array(
            array('InvalidClassA', 'ExpectedClassB'),
            array('InvalidClassC', 'ExpectedClassD'),
            array('InvalidClassD', 'ExpectedClassE'),
            array('InvalidClassE', 'ExpectedClassF'),
            array('InvalidClassF', 'ExpectedClassG'),
        );
    }
}

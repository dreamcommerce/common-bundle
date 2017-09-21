<?php

/*
 * (c) 2017 DreamCommerce
 *
 * @package DreamCommerce\Component\Common
 * @author Michał Korus <michal.korus@dreamcommerce.com>
 * @link https://www.dreamcommerce.com
 */

namespace DreamCommerce\Tests\Compontent\Common\Model;

use DreamCommerce\Component\Common\Exception\InvalidTypeException;
use DreamCommerce\Component\Common\Model\StdClassSplPriorityQueue;
use PHPUnit\Framework\TestCase;
use StdClass;

class StdClassSplPriorityQueueTest extends TestCase
{
    /**
     * @dataProvider unexpectedTypeDataProvider
     * @expectedException \DreamCommerce\Component\Common\Exception\InvalidTypeException
     * @expectedExceptionCode 57005
     */
    public function testUnexpectedType($given)
    {
        $queue = new StdClassSplPriorityQueue();
        $queue->insert($given, 1);
    }

    public function testValidType()
    {
        $c1 = new StdClass();
        $c2 = new StdClass();
        $c3 = new StdClass();
        $c1->id = 1;
        $c2->id = 2;
        $c3->id = 3;

        $queue = new StdClassSplPriorityQueue();

        $queue->insert($c1, 5);
        $queue->insert($c2, 10);
        $queue->insert($c3, 1);

        $queue->rewind();
        $this->assertCount(3, $queue);
        $this->assertEquals(2, $queue->current()->id);
        $queue->next();
        $this->assertEquals(1, $queue->current()->id);
        $queue->next();
        $this->assertEquals(3, $queue->current()->id);
        $this->assertCount(1, $queue);
        $queue->next();
        $this->assertCount(0, $queue);
    }

    public function unexpectedTypeDataProvider()
    {
        return array(
            array(1),
            array(array()),
            array('string'),
            array(new \Exception())
        );
    }
}

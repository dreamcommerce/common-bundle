<?php
namespace DreamCommerce\Component\Common\Model;

use StdClass;

class StdClassSplPriorityQueue extends TypedSplPriorityQueue
{
    protected $expectedObjectType = StdClass::class;
}
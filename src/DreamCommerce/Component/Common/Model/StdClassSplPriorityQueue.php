<?php

/*
 * (c) 2017 DreamCommerce
 *
 * @package DreamCommerce\Component\Common
 * @author Michał Korus <michal.korus@dreamcommerce.com>
 * @link https://www.dreamcommerce.com
 */

namespace DreamCommerce\Component\Common\Model;

use StdClass;

class StdClassSplPriorityQueue extends TypedSplPriorityQueue
{
    protected $expectedObjectType = StdClass::class;
}

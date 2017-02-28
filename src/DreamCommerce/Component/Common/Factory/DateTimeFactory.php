<?php

/*
 * (c) 2017 DreamCommerce
 *
 * @package DreamCommerce\Component\Common
 * @author Michał Korus <michal.korus@dreamcommerce.com>
 * @link https://www.dreamcommerce.com
 */

namespace DreamCommerce\Component\Common\Factory;

use DateTime;
use Sylius\Component\Resource\Factory\FactoryInterface;

class DateTimeFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createNew()
    {
        return new DateTime();
    }
}

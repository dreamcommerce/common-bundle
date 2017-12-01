<?php

/*
 * (c) 2017 DreamCommerce
 *
 * @package DreamCommerce\Component\Common
 * @author Michał Korus <michal.korus@dreamcommerce.com>
 * @link https://www.dreamcommerce.com
 */

declare(strict_types=1);

namespace DreamCommerce\Component\Common\Factory;

use DateTime;
use DateTimeZone;

class DateTimeFactory implements DateTimeFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createNew()
    {
        return new DateTime();
    }

    /**
     * {@inheritdoc}
     */
    public function createNewWithTimezone(DateTimeZone $timezone): DateTime
    {
        return new DateTime("now", $timezone);
    }
}

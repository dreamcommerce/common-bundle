<?php

declare(strict_types=1);

namespace DreamCommerce\Component\Common\Factory;

use DateTime;
use DateTimeZone;
use Sylius\Component\Resource\Factory\FactoryInterface;

interface DateTimeFactoryInterface extends FactoryInterface
{
    /**
     * @param DateTimeZone $timezone
     * @return DateTime
     */
    public function createNewWithTimezone(DateTimeZone $timezone): DateTime;
}
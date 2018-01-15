<?php

/*
 * (c) 2017 DreamCommerce
 *
 * @package DreamCommerce\Component\Common
 * @author Michał Korus <michal.korus@dreamcommerce.com>
 * @link https://www.dreamcommerce.com
 */

declare(strict_types=1);

namespace DreamCommerce\Component\Common\Util;

use DateTime;
use Webmozart\Assert\Assert;

/**
 * Mock *sleep* functions
 */
class Sleeper
{
    /**
     * @param int $seconds
     */
    public function sleep(int $seconds): void
    {
        sleep($seconds);
    }

    /**
     * @param int $microSeconds
     */
    public function usleep(int $microSeconds): void
    {
        usleep($microSeconds);
    }

    /**
     * @param DateTime|float $timestamp
     */
    public function sleepUntil($timestamp): void
    {
        if($timestamp instanceof DateTime) {
            $timestamp = $timestamp->getTimestamp();
        }

        Assert::numeric($timestamp);
        time_sleep_until($timestamp);
    }
}
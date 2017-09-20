<?php

/*
 * (c) 2017 DreamCommerce
 *
 * @package DreamCommerce\Component\Common
 * @author Michał Korus <michal.korus@dreamcommerce.com>
 * @link https://www.dreamcommerce.com
 */

class Date extends DateTime
{
    public function __construct($time)
    {
        parent::__construct($time, null);
        if (PHP_VERSION_ID < 71000) {
            $this->setTime(0, 0, 0);
        } else {
            $this->setTime(0, 0, 0, 0);
        }
    }

    public function __toString()
    {
        return $this->format('Y-m-d');
    }
}
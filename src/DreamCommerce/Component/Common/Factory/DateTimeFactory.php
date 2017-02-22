<?php

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

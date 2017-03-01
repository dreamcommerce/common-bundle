<?php

/*
 * (c) 2017 DreamCommerce
 *
 * @package DreamCommerce\Component\Common
 * @author Michał Korus <michal.korus@dreamcommerce.com>
 * @link https://www.dreamcommerce.com
 */

namespace DreamCommerce\Component\Common\Exception;

use Exception;

class NotDefinedException extends Exception
{
    const CODE_VARIABLE_NOT_DEFINED = 10;

    /**
     * @param string|null $variableName
     * @return NotDefinedException
     */
    public static function forVariable(string $variableName = null): NotDefinedException
    {
        if (empty($message)) {
            $message = 'Variable has been not defined';
        } else {
            $message = 'Variable "'.$variableName.'" has been not defined';
        }

        return new static($message, static::CODE_VARIABLE_NOT_DEFINED);
    }
}

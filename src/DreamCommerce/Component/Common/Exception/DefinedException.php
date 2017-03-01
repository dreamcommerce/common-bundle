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

class DefinedException extends Exception
{
    const CODE_VARIABLE_DEFINED = 10;

    /**
     * @param string|null $variableName
     * @return DefinedException
     */
    public static function forVariable(string $variableName = null): DefinedException
    {
        if (empty($message)) {
            $message = 'Variable has been defined';
        } else {
            $message = 'Variable "'.$variableName.'" has been defined';
        }

        return new static($message, static::CODE_VARIABLE_DEFINED);
    }
}

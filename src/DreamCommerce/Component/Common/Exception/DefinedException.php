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

class DefinedException extends Exception implements ContextInterface
{
    use ContextTrait;

    const CODE_VARIABLE_DEFINED = 10;

    /**
     * @var string
     */
    protected $variableName;

    /**
     * @param string|null $variableName
     * @return DefinedException
     */
    public static function forVariable(string $variableName = null): DefinedException
    {
        $exception = new static('The variable has been defined', static::CODE_VARIABLE_DEFINED);
        $exception->variableName = $variableName;

        return $exception;
    }

    /**
     * @return string
     */
    public function getVariableName(): string
    {
        return $this->variableName;
    }
}

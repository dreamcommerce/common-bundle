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

class NotDefinedException extends Exception implements ContextInterface
{
    use ContextTrait;

    const CODE_VARIABLE_NOT_DEFINED = 10;
    const CODE_PARAMETER_NOT_DEFINED = 11;

    /**
     * @var string
     */
    protected $variableName;

    /**
     * @var string
     */
    protected $parameterName;

    /**
     * @param string|null $variableName
     * @return NotDefinedException
     */
    public static function forVariable(string $variableName = null): NotDefinedException
    {
        $exception = new static('The variable has been not defined', static::CODE_VARIABLE_NOT_DEFINED);
        $exception->variableName = $variableName;

        return $exception;
    }

    /**
     * @param string|null $parameterName
     * @return NotDefinedException
     */
    public static function forParameter(string $parameterName = null): NotDefinedException
    {
        $exception = new static('The parameter has been not defined', static::CODE_PARAMETER_NOT_DEFINED);
        $exception->parameterName = $parameterName;

        return $exception;
    }

    /**
     * @return string|null
     */
    public function getVariableName()
    {
        return $this->variableName;
    }

    /**
     * @return string|null
     */
    public function getParameterName()
    {
        return $this->parameterName;
    }
}

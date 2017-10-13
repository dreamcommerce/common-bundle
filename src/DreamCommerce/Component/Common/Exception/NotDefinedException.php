<?php

/*
 * (c) 2017 DreamCommerce
 *
 * @package DreamCommerce\Component\Common
 * @author Michał Korus <michal.korus@dreamcommerce.com>
 * @link https://www.dreamcommerce.com
 */

declare(strict_types=1);

namespace DreamCommerce\Component\Common\Exception;

use Exception;
use Throwable;

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
     * @param Throwable $previousException
     * @return NotDefinedException
     */
    public static function forVariable(string $variableName = null, Throwable $previousException = null): NotDefinedException
    {
        $exception = new static('The variable has been not defined', static::CODE_VARIABLE_NOT_DEFINED, $previousException);
        $exception->variableName = $variableName;

        return $exception;
    }

    /**
     * @param string|null $parameterName
     * @param Throwable $previousException
     * @return NotDefinedException
     */
    public static function forParameter(string $parameterName = null, Throwable $previousException = null): NotDefinedException
    {
        $exception = new static('The parameter has been not defined', static::CODE_PARAMETER_NOT_DEFINED, $previousException);
        $exception->parameterName = $parameterName;

        return $exception;
    }

    /**
     * @return string|null
     */
    public function getVariableName(): ?string
    {
        return $this->variableName;
    }

    /**
     * @return string|null
     */
    public function getParameterName(): ?string
    {
        return $this->parameterName;
    }
}

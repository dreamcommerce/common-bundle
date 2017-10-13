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

class DefinedException extends Exception implements ContextInterface
{
    use ContextTrait;

    const CODE_VARIABLE_DEFINED = 10;
    const CODE_PARAMETER_DEFINED = 11;

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
     * @return DefinedException
     */
    public static function forVariable(string $variableName = null, Throwable $previousException = null): DefinedException
    {
        $exception = new static('The variable has been defined', static::CODE_VARIABLE_DEFINED, $previousException);
        $exception->variableName = $variableName;

        return $exception;
    }

    /**
     * @param string|null $parameterName
     * @param Throwable $previousException
     * @return DefinedException
     */
    public static function forParameter(string $parameterName = null, Throwable $previousException = null): DefinedException
    {
        $exception = new static('The parameter has been defined', static::CODE_PARAMETER_DEFINED, $previousException);
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

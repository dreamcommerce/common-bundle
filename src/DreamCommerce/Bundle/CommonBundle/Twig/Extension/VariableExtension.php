<?php

/*
 * (c) 2017 DreamCommerce
 *
 * @package DreamCommerce\Component\Common
 * @author Michał Korus <michal.korus@dreamcommerce.com>
 * @link https://www.dreamcommerce.com
 */

declare(strict_types=1);

namespace DreamCommerce\Bundle\CommonBundle\Twig\Extension;

use ReflectionClass;
use Twig_Extension;
use Twig_SimpleFunction;
use Twig_SimpleTest;

class VariableExtension extends Twig_Extension
{
    public function getTests()
    {
        $tests = array(
            'instanceof' =>  new Twig_SimpleTest(
                'instanceof',
                function ($var, $instance) {
                    return $var instanceof $instance;
                }
            )
        );

        $methods = array(
            'object',
            'array',
            'bool',
            'numeric',
            'scalar'
        );

        foreach ($methods as $method) {
            $tests[$method] = new Twig_SimpleTest(
                $method,
                function ($var) use ($method) {
                    return call_user_func('is_' . $method, $var);
                }
            );
        }

        foreach (array( 'int', 'integer' ) as $test) {
            $tests[$test] = new Twig_SimpleTest(
                $test,
                function ($var) {
                    return is_numeric($var) && (string)(int)$var == (string)$var;
                }
            );
        }
        $tests['float'] = new Twig_SimpleTest(
            'float',
            function ($var) {
                return is_numeric($var) && (string)(float)$var == (string)$var;
            }
        );

        return $tests;
    }

    public function getFunctions()
    {
        return array(
            'short_class' => new Twig_SimpleFunction(
                'short_class',
                function ($object) {
                    return (new ReflectionClass($object))->getShortName();
                }
            ),
            'class' => new Twig_SimpleFunction(
                'class',
                function ($object) {
                    return (new ReflectionClass($object))->getName();
                }
            )
        );
    }
}

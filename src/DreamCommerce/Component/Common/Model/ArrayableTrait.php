<?php

/*
 * (c) 2017 DreamCommerce
 *
 * @package DreamCommerce\Component\Common
 * @author Michał Korus <michal.korus@dreamcommerce.com>
 * @link https://www.dreamcommerce.com
 */

declare(strict_types=1);

namespace DreamCommerce\Component\Common\Model;

use ArrayAccess;
use DateTime;
use Webmozart\Assert\Assert;

trait ArrayableTrait
{
    /**
     * @param object|null $object
     *
     * @return array
     */
    public function toArray($object = null): array
    {
        Assert::nullOrObject($object);

        if ($object === null) {
            $object = $this;
        }

        $ignoredProperties = array();
        if ($object instanceof ArrayableInterface) {
            $ignoredProperties = $object->getIgnoredProperties();
        }
        $arr = get_object_vars($object);

        $func = function ($var) {
            if ($var instanceof ArrayableInterface) {
                return $var->toArray();
            } elseif ($var instanceof DateTime) {
                return $var->format(\DateTime::ISO8601);
            } elseif ($var instanceof ArrayAccess) {
                return (array) $var;
            } elseif (class_exists('\Sylius\Component\Resource\Model\ResourceInterface')) {
                if ($var instanceof \Sylius\Component\Resource\Model\ResourceInterface) {
                    return get_class($var).'#'.$var->getId();
                }
            }

            return get_class($var);
        };

        foreach ($arr as $k => $v) {
            if (substr($k, 0, 2) == '__') {
                unset($arr[$k]);
            } elseif (in_array($k, $ignoredProperties)) {
                unset($arr[$k]);
            } elseif (is_resource($v)) {
                unset($arr[$k]);
            } elseif (is_object($v)) {
                if (interface_exists('\Doctrine\Collections\Collection')) {
                    if ($v instanceof \Doctrine\Collections\Collection) {
                        $list = array();
                        foreach ($v as $v2) {
                            $list[] = $func($v2);
                        }
                        $arr[$k] = $list;

                        continue;
                    }
                }

                $arr[$k] = $func($v);
            }
        }

        return $arr;
    }

    /**
     * @param object|null $object
     * @param array       $params
     */
    public function fromArray(array $params = array(), $object = null): void
    {
        Assert::nullOrObject($object);

        if ($object === null) {
            $object = $this;
        }

        $ignoredProperties = array();
        if ($object instanceof ArrayableInterface) {
            $ignoredProperties = $object->getIgnoredProperties();
        }

        foreach ($params as $option => $value) {
            if (in_array($option, $ignoredProperties)) {
                continue;
            }

            $option = ucfirst($option);
            $funcName = 'set'.$option;
            if (method_exists($object, $funcName)) {
                call_user_func(array($object, $funcName), $value);
                continue;
            }

            $camelCase = str_replace(' ', '', ucwords(str_replace('_', ' ', $option)));
            $funcName = 'set'.$camelCase;
            if (method_exists($object, $funcName)) {
                call_user_func(array($object, $funcName), $value);
                continue;
            }

            if (property_exists($object, $option)) {
                $object->$camelCase = $value;
                continue;
            }

            if (property_exists($object, '_'.$option)) {
                $object->$camelCase = $value;
                continue;
            }

            $camelCase = lcfirst($camelCase);
            if (property_exists($object, $camelCase)) {
                $object->$camelCase = $value;
                continue;
            }

            $camelCase = '_'.$camelCase;
            if (property_exists($object, $camelCase)) {
                $object->$camelCase = $value;
                continue;
            }
        }
    }

    /**
     * @return array
     */
    public function getIgnoredProperties(): array
    {
        return array();
    }
}

<?php

/*
 * (c) 2017 DreamCommerce
 *
 * @package DreamCommerce\Component\Common
 * @author Michał Korus <michal.korus@dreamcommerce.com>
 * @link https://www.dreamcommerce.com
 */

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

        $ignoredProperties = $this->getIgnoredProperties();
        $arr = get_object_vars($object);

        foreach ($arr as $k => $v) {
            if(is_array($ignoredProperties) && in_array($k, $ignoredProperties)) {
                unset($arr[$k]);
            } elseif (is_resource($v)) {
                unset($arr[$k]);
            } elseif (is_object($v)) {
                if ($v instanceof ArrayableInterface) {
                    $arr[$k] = $v->toArray();
                } elseif ($v instanceof DateTime) {
                    $arr[$k] = $v->format(\DateTime::ISO8601);
                } elseif ($v instanceof ArrayAccess) {
                    $arr[$k] = (array) $v;
                } elseif (class_exists('Sylius\Component\Resource\Model\ResourceInterface')) {
                    if ($v instanceof Sylius\Component\Resource\Model\ResourceInterface) {
                        $arr[$k] = get_class($v).'#'.$v->getId();
                    }
                }

                if (is_object($arr[$k])) {
                    $arr[$k] = get_class($arr[$k]);
                }
            }
        }

        return $arr;
    }

    /**
     * @param object|null $object
     * @param array       $params
     *
     * @return $this
     */
    public function fromArray(array $params = array(), $object = null)
    {
        Assert::nullOrObject($object);

        $ignoredProperties = $this->getIgnoredProperties();

        foreach ($params as $option => $value) {
            if(is_array($ignoredProperties) && in_array($option, $ignoredProperties)) {
                continue;
            }

            $option = ucfirst($option);
            $funcName = 'set'.$option;
            if (method_exists($this, $funcName)) {
                call_user_func(array($this, $funcName), $value);
                continue;
            }

            $camelCase = str_replace(' ', '', ucwords(str_replace('_', ' ', $option)));
            $funcName = 'set'.$camelCase;
            if (method_exists($this, $funcName)) {
                call_user_func(array($this, $funcName), $value);
                continue;
            }

            if (property_exists($this, $option)) {
                $this->$camelCase = $value;
                continue;
            }

            if (property_exists($this, '_'.$option)) {
                $this->$camelCase = $value;
                continue;
            }

            $camelCase = lcfirst($camelCase);
            if (property_exists($this, $camelCase)) {
                $this->$camelCase = $value;
                continue;
            }

            $camelCase = '_'.$camelCase;
            if (property_exists($this, $camelCase)) {
                $this->$camelCase = $value;
                continue;
            }
        }

        return $this;
    }

    /**
     * @return array|null
     */
    public function getIgnoredProperties()
    {
        return null;
    }
}

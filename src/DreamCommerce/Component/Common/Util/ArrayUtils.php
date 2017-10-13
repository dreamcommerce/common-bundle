<?php

/*
 * (c) 2017 DreamCommerce
 *
 * @package DreamCommerce\Component\Common
 * @author Michał Korus <michal.korus@dreamcommerce.com>
 * @link https://www.dreamcommerce.com
 */

declare(strict_types=1);

namespace DreamCommerce\Component\Common\Util;

final class ArrayUtils
{
    /**
     * @param array $arr1
     * @param array $arr2
     * @return array
     */
    public static function diff(array $arr1, array $arr2): array
    {
        $result = array();

        foreach ($arr1 as $k => $v) {
            if (array_key_exists($k, $arr2)) {
                if (is_array($v)) {
                    $diff = self::diff($v, $arr2[$k]);
                    if (count($diff)) {
                        $result[$k] = $diff;
                    }
                } elseif ($v != $arr2[$k]) {
                    $result[$k] = $v;
                }
            } else {
                $result[$k] = $v;
            }
        }
        return $result;
    }

    /**
     * @param array $arr
     * @param bool $keepKeys
     * @return array
     */
    public static function unique(array $arr, bool $keepKeys = false): array
    {
        if ($keepKeys) {
            $arr = array_reverse($arr, true);
        }
        $flip = array_flip($arr);
        if (!$keepKeys) {
            return array_keys($flip);
        }
        return array_flip($flip);
    }

    /**
     * @param array $array , $array2[, $array3, ...]
     * @return array
     */
    public static function intersect(array $array): array
    {
        if (($argsCnt = func_num_args()) < 2) {
            throw new \InvalidArgumentException('At least 2 arrays must be passed');
        }
        $array2 = func_get_arg(1);
        if (!is_array($array2)) {
            throw new \InvalidArgumentException('All the arguments must be array');
        }
        $flip = array_flip($array2);
        foreach ($array as $key => $value) {
            if (!isset($flip[$value])) {
                unset($array[$key]);
            }
        }
        if ($argsCnt > 2) {
            $args = func_get_args();
            $args = array_slice($args, 2);
            array_unshift($args, $array);
            return call_user_func_array(array(__CLASS__, __FUNCTION__), $args);
        }

        return $array;
    }
}

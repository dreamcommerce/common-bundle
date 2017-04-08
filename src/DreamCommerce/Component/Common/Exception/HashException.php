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

class HashException extends Exception implements ContextInterface
{
    use ContextTrait;

    const CODE_NOT_EQUALS_HASH = 10;

    /**
     * @var string
     */
    protected $hash;

    /**
     * @var string
     */
    protected $comparedHash;

    /**
     * @param string $hash
     * @param string $comparedHash
     * @return HashException
     */
    public static function forNotEqualsHash(string $hash, string $comparedHash): HashException
    {
        $exception = new self('Hashes are not equals', static::CODE_NOT_EQUALS_HASH);
        $exception->hash = $hash;
        $exception->comparedHash = $comparedHash;

        return $exception;
    }

    /**
     * @return string|null
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @return string|null
     */
    public function getComparedHash()
    {
        return $this->comparedHash;
    }
}
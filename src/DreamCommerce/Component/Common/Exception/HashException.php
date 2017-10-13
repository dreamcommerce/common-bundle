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
     * @param Throwable $previousException
     * @return HashException
     */
    public static function forNotEqualsHash(string $hash, string $comparedHash, Throwable $previousException = null): HashException
    {
        $exception = new self('Hashes are not equal', static::CODE_NOT_EQUALS_HASH, $previousException);
        $exception->hash = $hash;
        $exception->comparedHash = $comparedHash;

        return $exception;
    }

    /**
     * @return string|null
     */
    public function getHash(): ?string
    {
        return $this->hash;
    }

    /**
     * @return string|null
     */
    public function getComparedHash(): ?string
    {
        return $this->comparedHash;
    }
}

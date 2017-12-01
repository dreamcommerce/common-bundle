<?php

declare(strict_types=1);

namespace DreamCommerce\Component\Common\Factory;

use Psr\Http\Message\UriInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

interface UriFactoryInterface extends FactoryInterface
{
    /**
     * @param string $uri
     * @return UriInterface
     */
    public function createNewByUriString(string $uri): UriInterface;
}
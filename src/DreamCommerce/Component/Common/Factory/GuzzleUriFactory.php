<?php

declare(strict_types=1);

namespace DreamCommerce\Component\Common\Factory;

use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\UriInterface;

class GuzzleUriFactory implements UriFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createNew()
    {
        return new Uri();
    }

    /**
     * {@inheritdoc}
     */
    public function createNewByUriString(string $uri): UriInterface
    {
        return new Uri($uri);
    }
}
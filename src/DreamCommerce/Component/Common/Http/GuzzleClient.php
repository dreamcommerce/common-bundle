<?php

/*
 * (c) 2017 DreamCommerce
 *
 * @package DreamCommerce\Component\Common
 * @author Michał Korus <michal.korus@dreamcommerce.com>
 * @link https://www.dreamcommerce.com
 */

declare(strict_types=1);

namespace DreamCommerce\Component\Common\Http;

use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use GuzzleHttp\Psr7;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

class GuzzleClient implements ClientInterface
{
    /**
     * @var GuzzleClientInterface
     */
    private $guzzleClient;

    /**
     * @param GuzzleClientInterface $guzzleClient
     */
    public function __construct(GuzzleClientInterface $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
    }

    /**
     * {@inheritdoc}
     */
    public function send(RequestInterface $request, array $options = array()): ResponseInterface
    {
        return $this->guzzleClient->send($request, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function request(string $method, $uri, array $options = array()): ResponseInterface
    {
        return $this->guzzleClient->request($method, $uri, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function createRequest(string $method, $uri, array $headers = array(), $body = null, string $protocolVersion = '1.1'): RequestInterface
    {
        return new Request($method, $uri, $headers, $body, $protocolVersion);
    }

    /**
     * {@inheritdoc}
     */
    public function createUri(string $uri = null): UriInterface
    {
        return new Uri($uri);
    }

    /**
     * {@inheritdoc}
     */
    public function createStream($data): StreamInterface
    {
        return Psr7\stream_for($data);
    }
}

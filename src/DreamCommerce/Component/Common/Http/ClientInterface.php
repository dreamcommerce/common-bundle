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

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

interface ClientInterface
{
    /**
     * @param RequestInterface $request
     * @param array $options - Vendor-specific options, don't rely on for interop
     *
     * @return ResponseInterface
     */
    public function send(RequestInterface $request, array $options = array()): ResponseInterface;

    /**
     * @param string              $method
     * @param string|UriInterface $uri
     * @param array               $options - Vendor-specific options, don't rely on for interop.
     *
     * Standard compliant client must implement the following options:
     *
     * - "headers" is a list of headers, for example ["Content-Type: application/json"]
     * - "body" contains the HTTP body if sending POST, PUT, ...
     *
     * @return ResponseInterface
     */
    public function request(string $method, $uri, array $options = array()): ResponseInterface;

    /**
     * @param null|string                     $method          HTTP method for the request
     * @param null|string|UriInterface        $uri             URI for the request
     * @param array                           $headers         Headers for the message
     * @param string|resource|StreamInterface $body            Message body
     * @param string                          $protocolVersion HTTP protocol version
     *
     * @return RequestInterface
     */
    public function createRequest(string $method, $uri, array $headers = array(), $body = null, string $protocolVersion = '1.1'): RequestInterface;
    /**
     * @param string $uri - If uri is provided the result of parse_url() is set as parts for UriInterface
     *
     * @throws \InvalidArgumentException When passed $uri is not a string or not parsable uri
     *
     * @return UriInterface
     */
    public function createUri(string $uri = null): UriInterface;
    /**
     * @param mixed $data
     *
     * @throws \InvalidArgumentException When passed data cannot be converted to a stream
     *
     * @return StreamInterface
     */
    public function createStream($data): StreamInterface;
}

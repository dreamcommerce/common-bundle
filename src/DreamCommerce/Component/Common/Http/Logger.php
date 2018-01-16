<?php

/*
 * This file is part of the DreamCommerce Shop AppStore package.
 *
 * (c) DreamCommerce
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace DreamCommerce\Component\Common\Http;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface as PsrLoggerInterface;

final class Logger implements LoggerInterface
{
    /**
     * @var PsrLoggerInterface
     */
    private $logger;

    /**
     * @param PsrLoggerInterface $logger
     */
    public function __construct(PsrLoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param RequestInterface $request
     */
    public function logRequest(RequestInterface $request): void
    {
        $uri = $request->getUri();
        $stream = $request->getBody();
        $body = $stream->getContents();
        $stream->rewind();

        $this->logger->debug(
            'Send request to "' . $uri->getHost() . '"',
            [
                'uri' => $uri->__toString(),
                'headers' => $request->getHeaders(),
                'body' => $body
            ]
        );
    }

    /**
     * @param ResponseInterface $response
     */
    public function logResponse(ResponseInterface $response): void
    {
        $stream = $response->getBody();
        $body = $stream->getContents();
        $stream->rewind();

        $this->logger->debug(
            'Received a response',
            [
                'status_code' => $response->getStatusCode(),
                'headers' => $response->getHeaders(),
                'body' => $body
            ]
        );
    }
}
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

interface LoggerInterface
{
    /**
     * @param RequestInterface $request
     */
    public function logRequest(RequestInterface $request): void;

    /**
     * @param ResponseInterface $response
     */
    public function logResponse(ResponseInterface $response): void;
}
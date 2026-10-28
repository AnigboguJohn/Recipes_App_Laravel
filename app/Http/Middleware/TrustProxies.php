<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;

class TrustProxies extends Middleware
{
    /**
     * Hosting platforms (Render, Railway...) sit behind a proxy that terminates HTTPS.
     * Trusting it makes links and form actions use https://.
     *
     * @var array|string|null
     */
    protected $proxies = '*';

    /**
     * @var int
     */
    protected $headers = Request::HEADER_X_FORWARDED_FOR | Request::HEADER_X_FORWARDED_HOST | Request::HEADER_X_FORWARDED_PORT | Request::HEADER_X_FORWARDED_PROTO;
}

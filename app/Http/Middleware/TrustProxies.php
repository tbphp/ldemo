<?php

namespace App\Http\Middleware;

use Fideloper\Proxy\TrustProxies as Middleware;
use Illuminate\Contracts\Config\Repository;
use Symfony\Component\HttpFoundation\Request;

class TrustProxies extends Middleware
{
    public function __construct(Repository $config)
    {
        $header = config('app.proxy_header');
        $headers = request()->headers;
        if ($headers->has($header)) {
            $headers->set('x-forwarded-for', $headers->get($header));
        }

        parent::__construct($config);
    }

    /**
     * The trusted proxies for this application.
     *
     * @var array|string|null
     */
    protected $proxies = '*';

    /**
     * The headers that should be used to detect proxies.
     *
     * @var int
     */
    protected $headers = Request::HEADER_X_FORWARDED_FOR;
}

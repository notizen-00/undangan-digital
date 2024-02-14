<?php

namespace App\Middleware;

use Closure;
use Core\Http\Request;
use Core\Http\Response;
use Core\Middleware\MiddlewareInterface;

final class CorsMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $header = $response->getHeader();
        $header->set('Access-Control-Allow-Origin', '*');
        $header->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $header->set('Access-Control-Allow-Headers', 'Origin, Content-Type, Accept, Authorization');

        // Handle preflight requests
        if ($request->method() === 'OPTIONS') {
            $header->unset('Content-Type');

            if (!$request->server->has('HTTP_ACCESS_CONTROL_REQUEST_METHOD')) {
                return new Response(null, Response::HTTP_NO_CONTENT);
            }

            $header->set('Access-Control-Allow-Methods', strtoupper($request->server->get('HTTP_ACCESS_CONTROL_REQUEST_METHOD', 'GET')));
            $header->set('Access-Control-Allow-Headers', $request->server->get('HTTP_ACCESS_CONTROL_REQUEST_HEADERS', 'Accept, Authorization, Content-Type, Origin, Token, User-Agent'));

            return new Response(null, Response::HTTP_NO_CONTENT);
        }

        return $response;
    }
}

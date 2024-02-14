<?php

namespace App\Middleware;

use Closure;
use Core\Http\Request;
use Core\Http\Respond;
use Core\Middleware\MiddlewareInterface;

final class CorsMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->ajax() && !$request->method(Request::OPTIONS)) {
            return $next($request);
        }

        $header = respond()->getHeader();
        // Set Access-Control-Allow-Origin header to allow all origins
        $header->set('Access-Control-Allow-Origin', '*');

        $vary = (!$header->has('Vary')) ? [] : explode(', ', $header->get('Vary'));
        $vary = array_unique([...$vary, 'Accept', 'Access-Control-Request-Method', 'Access-Control-Request-Headers', 'Origin', 'User-Agent']);
        $header->set('Vary', join(', ', $vary));

        if (!$request->method(Request::OPTIONS)) {
            return $next($request);
        }

        $header->unset('Content-Type');

        if (!$request->server->has('HTTP_ACCESS_CONTROL_REQUEST_METHOD')) {
            return respond()->setCode(Respond::HTTP_NO_CONTENT);
        }

        $header->set(
            'Access-Control-Allow-Methods',
            strtoupper($request->server->get('HTTP_ACCESS_CONTROL_REQUEST_METHOD', $request->method(),'GET,POST,DELETE,PUT,OPTIONS'))
        );

        $header->set(
            'Access-Control-Allow-Headers',
            $request->server->get('HTTP_ACCESS_CONTROL_REQUEST_HEADERS', 'Accept, Authorization, Content-Type, Origin, Token, User-Agent,POST, OPTIONS,GET,PUT,DELETE')
        );

        return respond()->setCode(Respond::HTTP_NO_CONTENT);
    }
}

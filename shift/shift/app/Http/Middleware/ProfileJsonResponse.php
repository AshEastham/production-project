<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;

class ProfileJsonResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Middleware which allows the use of Laravel debugbar when _debug is passed in the HTTP request
        // enables easy testing of amount of queries that is being sent from endpoints.
        // currently just measuring the amount of queries sent to the database, improved with eager loading.
        $response = $next($request);

        if ($response instanceof JsonResponse && app('debugbar')->isEnabled() && $request->has('_debug')) {
            $response->setData($response->getData(true) + [
                '_debugbar' => array_only(app('debugbar')->getData(), 'queries')
            ]);
        }

        return $response;
    }
}

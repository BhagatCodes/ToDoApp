<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class ensureGuestId
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $guest_id = $request->cookie('guest_id');
        if(!$guest_id){
            $guest_id = (string) Str::uuid();

            cookie()->queue(
                cookie('guest_id', $guest_id, 60*24*30)
            );
        }
        return $next($request);
    }
}

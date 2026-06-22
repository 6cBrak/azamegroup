<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth('customer')->check()) {
            return redirect()->route('account.login')
                ->with('error', 'Veuillez vous connecter pour accéder à votre compte.');
        }
        return $next($request);
    }
}

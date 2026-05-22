<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!$request->user()) {
            return redirect('login');
        }

        foreach ($roles as $role) {
            if ($request->user()->role->name === $role) {
                return $next($request);
            }
        }

        return redirect()->route('home')->with('error', 'You do not have permission to access this area.');
    }
}

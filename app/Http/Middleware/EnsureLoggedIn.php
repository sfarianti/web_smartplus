<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureLoggedIn
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('id_tentor') && !session()->has('id_user')) {
            return redirect()->route('login')->withErrors([
                'error' => 'Silakan login terlebih dahulu.',
            ]);
        }

        return $next($request);
    }
}


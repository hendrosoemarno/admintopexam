<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfNotMoodleAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('moodle_user')) {
            return redirect()->route('moodle.login');
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Arr;

class Authenticate extends Middleware
{
    protected array $guards;

    public function handle($request, Closure $next, ...$guards)
    {
        $this->guards = $guards;

        return parent::handle($request, $next, ...$guards);
    }

    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            if (Arr::first($this->guards) === 'staff') {
                return route('backend.login');
            }

            return route('login');
        }
    }
}

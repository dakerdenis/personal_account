<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RestrictIpMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $clientIpLong = ip2long($request->ip());

        // Updated IP ranges
        $allowedRanges = [
            ['start' => ip2long('172.20.80.0'), 'end' => ip2long('172.20.80.31')], // Existing 172.20.80.0/27
            ['start' => ip2long('172.20.75.0'), 'end' => ip2long('172.20.75.15')], // Existing 172.20.75.0/28
            ['start' => ip2long('10.212.134.0'), 'end' => ip2long('10.212.134.255')], // Added 10.212.134.0/24
            ['start' => ip2long('172.20.86.0'), 'end' => ip2long('172.20.86.15')], // Added 172.20.86.0/28
        ];

        $allowedIps = [
            '213.172.90.111',
            '213.172.90.110',
            '213.172.90.109',
            '217.64.24.97',
            '37.26.3.122',
        ];

        $isAllowed = false;

        foreach ($allowedRanges as $range) {
            if ($clientIpLong >= $range['start'] && $clientIpLong <= $range['end']) {
                $isAllowed = true;
                break;
            }
        }

        if (in_array($request->ip(), $allowedIps)) {
            $isAllowed = true;
        }

        if (config('app.env') === 'production' && !$isAllowed) {
            abort(403);
        }

        return $next($request);
    }
}

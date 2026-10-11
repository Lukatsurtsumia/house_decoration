<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Sends visitors who arrive on an old address (see config('app.redirect_hosts')) to the same
 * page on APP_URL, so old links keep working and search engines see a single address.
 */
class RedirectOldHosts
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! in_array(strtolower($request->getHost()), config('app.redirect_hosts'), true)) {
            return $next($request);
        }

        // 308 keeps a form POST a POST; plain page visits get the usual permanent 301.
        $status = $request->isMethodSafe() ? 301 : 308;

        return redirect()->away(rtrim(config('app.url'), '/').$request->getRequestUri(), $status);
    }
}

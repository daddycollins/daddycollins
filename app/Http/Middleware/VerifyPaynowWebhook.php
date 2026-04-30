<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VerifyPaynowWebhook
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // In development, allow all webhook requests
        if (config('app.env') !== 'production') {
            return $next($request);
        }

        // Paynow sends a hash parameter to verify webhook authenticity
        $hash = $request->input('hash');

        if (!$hash) {
            Log::warning('Paynow webhook received without hash', [
                'ip' => $request->ip(),
                'data' => $request->all()
            ]);
            return response('Unauthorized', 401);
        }

        // TODO: Implement proper hash verification based on Paynow's documentation
        // The hash is typically calculated from the webhook data using a specific algorithm
        // For now, we log and allow in production (implement proper verification before going live)

        Log::info('Paynow webhook hash received', [
            'hash' => $hash,
            'ip' => $request->ip()
        ]);

        return $next($request);
    }
}

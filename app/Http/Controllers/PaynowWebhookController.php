<?php

namespace App\Http\Controllers;

use App\Services\PaynowService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaynowWebhookController extends Controller
{
    protected $paynowService;

    public function __construct(PaynowService $paynowService)
    {
        $this->paynowService = $paynowService;
    }

    /**
     * Handle Paynow webhook notification
     */
    public function handle(Request $request)
    {
        // Log incoming webhook for debugging
        Log::info('Paynow webhook received', [
            'data' => $request->all(),
            'ip' => $request->ip()
        ]);

        $data = $request->all();

        $success = $this->paynowService->processWebhookPayment($data);

        // Paynow expects an "OK" response
        return response($success ? 'OK' : 'FAILED', $success ? 200 : 400);
    }
}

<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Paynow Integration ID
    |--------------------------------------------------------------------------
    |
    | This is your Paynow integration ID. You can get this from your
    | Paynow merchant dashboard.
    |
    */

    'integration_id' => env('PAYNOW_INTEGRATION_ID'),

    /*
    |--------------------------------------------------------------------------
    | Paynow Integration Key
    |--------------------------------------------------------------------------
    |
    | This is your Paynow integration key. Keep this secret and never
    | commit it to version control.
    |
    */

    'integration_key' => env('PAYNOW_INTEGRATION_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Result URL
    |--------------------------------------------------------------------------
    |
    | This is the URL that Paynow will POST payment status updates to.
    | This should be a publicly accessible URL (webhook endpoint).
    |
    */

    'result_url' => env('PAYNOW_RESULT_URL', env('APP_URL') . '/paynow/webhook'),

    /*
    |--------------------------------------------------------------------------
    | Return URL
    |--------------------------------------------------------------------------
    |
    | This is the URL that customers will be redirected to after completing
    | or cancelling a payment on the Paynow gateway.
    |
    */

    'return_url' => env('PAYNOW_RETURN_URL', env('APP_URL') . '/checkout/success'),

    /*
    |--------------------------------------------------------------------------
    | Mode
    |--------------------------------------------------------------------------
    |
    | Set to 'sandbox' for testing or 'live' for production.
    |
    */

    'mode' => env('PAYNOW_MODE', 'sandbox'),

];

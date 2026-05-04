<?php
/**
 * PayNow Test Credentials Setup
 * 
 * Run this script via: php SetupPaynowTestCredentials.php
 * 
 * This sets up test/demo credentials for all artisans
 */

require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
  $request = \Illuminate\Http\Request::capture()
);

// PayNow Test Credentials (Demo mode)
// These are example test credentials from PayNow documentation
const PAYNOW_TEST_INTEGRATION_ID = 'TESTWEB';
const PAYNOW_TEST_INTEGRATION_KEY = 'test';

use App\Models\ArtisanProfile;
use App\Models\PaynowAccount;

$artisans = ArtisanProfile::all();

echo "Setting up PayNow test credentials for " . count($artisans) . " artisans...\n\n";

foreach ($artisans as $artisan) {
  $paynowAccount = PaynowAccount::where('artisan_id', $artisan->id)->first();

  if (!$paynowAccount) {
    $paynowAccount = PaynowAccount::create([
      'artisan_id' => $artisan->id,
      'paynow_integration_id' => PAYNOW_TEST_INTEGRATION_ID,
      'paynow_integration_key' => PAYNOW_TEST_INTEGRATION_KEY,
      'account_holder' => $artisan->business_name,
      'account_type' => 'mobile_money',
      'phone_number' => '+263784123456',
      'status' => 'active',
      'is_primary' => true,
    ]);

    echo "✓ Created PayNow account for: {$artisan->business_name}\n";
  } else if (empty($paynowAccount->paynow_integration_id)) {
    $paynowAccount->update([
      'paynow_integration_id' => PAYNOW_TEST_INTEGRATION_ID,
      'paynow_integration_key' => PAYNOW_TEST_INTEGRATION_KEY,
      'status' => 'active',
    ]);

    echo "✓ Updated PayNow account for: {$artisan->business_name}\n";
  } else {
    echo "○ PayNow account already configured for: {$artisan->business_name}\n";
  }
}

echo "\n✓ PayNow test credentials setup complete!\n";
echo "\nNote: These are TEST credentials for development only.\n";
echo "For production, use actual PayNow merchant credentials.\n";
echo "Visit: https://paynow.co.zw/merchants/ to get production credentials\n";

$kernel->terminate($request, $response);
?>
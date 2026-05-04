<?php
require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
  $request = \Illuminate\Http\Request::capture()
);

use App\Models\PaynowAccount;

const PAYNOW_TEST_INTEGRATION_ID = 'TESTWEB';
const PAYNOW_TEST_INTEGRATION_KEY = 'test';

echo "=== Force-Updating All PayNow Credentials ===\n\n";

$accounts = PaynowAccount::all();

foreach ($accounts as $account) {
  $account->update([
    'paynow_integration_id' => PAYNOW_TEST_INTEGRATION_ID,
    'paynow_integration_key' => PAYNOW_TEST_INTEGRATION_KEY,
    'status' => 'active',
    'credentials_encrypted' => false, // Store as plain text
  ]);

  echo "✓ Updated Artisan ID {$account->artisan_id}\n";
}

echo "\n✓ All credentials updated to plain text!\n\n";

// Verify the update
echo "=== Verification ===\n\n";
$accounts = PaynowAccount::all();

foreach ($accounts as $account) {
  echo "Artisan {$account->artisan_id}: ";
  echo "ID={$account->paynow_integration_id}, ";
  echo "Key=" . (strlen($account->paynow_integration_key ?? '') > 0 ? '✓' : '❌') . ", ";
  echo "Encrypted={$account->credentials_encrypted}\n";
}

$kernel->terminate($request, $response);
?>
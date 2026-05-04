<?php
require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
  $request = \Illuminate\Http\Request::capture()
);

use App\Models\PaynowAccount;

echo "=== PayNow Accounts in Database ===\n\n";

$accounts = PaynowAccount::all();

if ($accounts->isEmpty()) {
  echo "❌ No PayNow accounts found!\n";
} else {
  foreach ($accounts as $account) {
    echo "Artisan ID: {$account->artisan_id}\n";
    echo "  Integration ID: " . ($account->paynow_integration_id ?: '❌ MISSING') . "\n";
    echo "  Integration Key: " . (strlen($account->paynow_integration_key ?? '') > 0 ? '✓ SET' : '❌ MISSING') . "\n";
    echo "  Status: {$account->status}\n";
    echo "  Encrypted: {$account->credentials_encrypted}\n";
    echo "\n";
  }
}

echo "Total accounts: " . count($accounts) . "\n";

$kernel->terminate($request, $response);
?>
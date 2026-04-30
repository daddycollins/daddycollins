<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add encrypted flag to paynow_accounts
        Schema::table('paynow_accounts', function (Blueprint $table) {
            $table->boolean('credentials_encrypted')->default(false)->after('paynow_integration_key');
        });

        // Encrypt existing keys (if any exist)
        $accounts = DB::table('paynow_accounts')->get();
        foreach ($accounts as $account) {
            if (!$account->credentials_encrypted && $account->paynow_integration_key) {
                try {
                    DB::table('paynow_accounts')
                        ->where('id', $account->id)
                        ->update([
                            'paynow_integration_key' => encrypt($account->paynow_integration_key),
                            'credentials_encrypted' => true
                        ]);
                } catch (\Exception $e) {
                    // Key might already be encrypted or invalid
                    \Log::warning('Could not encrypt Paynow key for account ' . $account->id);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Decrypt all keys before removing flag
        $accounts = DB::table('paynow_accounts')
            ->where('credentials_encrypted', true)
            ->get();

        foreach ($accounts as $account) {
            try {
                DB::table('paynow_accounts')
                    ->where('id', $account->id)
                    ->update([
                        'paynow_integration_key' => decrypt($account->paynow_integration_key),
                        'credentials_encrypted' => false
                    ]);
            } catch (\Exception $e) {
                \Log::warning('Could not decrypt Paynow key for account ' . $account->id);
            }
        }

        Schema::table('paynow_accounts', function (Blueprint $table) {
            $table->dropColumn('credentials_encrypted');
        });
    }
};

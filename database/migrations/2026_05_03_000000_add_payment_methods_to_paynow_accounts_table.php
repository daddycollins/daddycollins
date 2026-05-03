<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::table('paynow_accounts', function (Blueprint $table) {
      // Add payment method support fields
      if (!Schema::hasColumn('paynow_accounts', 'account_holder')) {
        $table->string('account_holder')->nullable()->after('artisan_id');
      }
      if (!Schema::hasColumn('paynow_accounts', 'account_type')) {
        $table->enum('account_type', ['paynow', 'bank', 'mobile_money'])->default('paynow')->after('account_holder');
      }
      if (!Schema::hasColumn('paynow_accounts', 'account_number')) {
        $table->string('account_number')->nullable()->after('account_type');
      }
      if (!Schema::hasColumn('paynow_accounts', 'phone_number')) {
        $table->string('phone_number')->nullable()->after('account_number');
      }
      if (!Schema::hasColumn('paynow_accounts', 'bank_name')) {
        $table->string('bank_name')->nullable()->after('phone_number');
      }
      if (!Schema::hasColumn('paynow_accounts', 'branch')) {
        $table->string('branch')->nullable()->after('bank_name');
      }
      if (!Schema::hasColumn('paynow_accounts', 'swift_code')) {
        $table->string('swift_code')->nullable()->after('branch');
      }
      if (!Schema::hasColumn('paynow_accounts', 'iban')) {
        $table->string('iban')->nullable()->after('swift_code');
      }
      if (!Schema::hasColumn('paynow_accounts', 'status')) {
        $table->enum('status', ['active', 'inactive', 'suspended'])->default('active')->after('iban');
      }
      if (!Schema::hasColumn('paynow_accounts', 'is_primary')) {
        $table->boolean('is_primary')->default(false)->after('status');
      }
      if (!Schema::hasColumn('paynow_accounts', 'notes')) {
        $table->text('notes')->nullable()->after('is_primary');
      }
    });
  }

  public function down(): void
  {
    Schema::table('paynow_accounts', function (Blueprint $table) {
      $columns = [
        'account_holder',
        'account_type',
        'account_number',
        'phone_number',
        'bank_name',
        'branch',
        'swift_code',
        'iban',
        'status',
        'is_primary',
        'notes'
      ];

      foreach ($columns as $column) {
        if (Schema::hasColumn('paynow_accounts', $column)) {
          $table->dropColumn($column);
        }
      }
    });
  }
};

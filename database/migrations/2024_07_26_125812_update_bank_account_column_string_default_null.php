<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bank_accounts', function (Blueprint $table) {
            //
            $table->string('bank_name')->nullable()->default(null)->change();
            $table->string('account_number')->nullable()->default(null)->change();
            $table->string('account_holder_name')->nullable()->default(null)->change();
            $table->string('branch_address')->nullable()->default(null)->change();
            $table->string('swift_code')->nullable()->default(null)->change();
            $table->string('iban')->nullable()->default(null)->change();
            $table->string('account_type')->nullable()->default(null)->change();
            $table->string('currency')->nullable()->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bank_accounts', function (Blueprint $table) {
            //
        });
    }
};

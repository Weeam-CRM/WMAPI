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
            $table->integer('bank_name')->nullable()->default(null)->change();
            $table->integer('account_number')->nullable()->default(null)->change();
            $table->integer('account_holder_name')->nullable()->default(null)->change();
            $table->integer('branch_address')->nullable()->default(null)->change();
            $table->integer('swift_code')->nullable()->default(null)->change();
            $table->integer('iban')->nullable()->default(null)->change();
            $table->integer('account_type')->nullable()->default(null)->change();
            $table->integer('currency')->nullable()->default(null)->change();
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

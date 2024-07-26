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
        Schema::table('developers', function (Blueprint $table) {
            //
            $table->integer('developer_id')->nullable()->default(null)->change();
            $table->integer('developer_name')->nullable()->default(null)->change();
            $table->integer('email')->nullable()->default(null)->change();
            $table->integer('phone_number')->nullable()->default(null)->change();
            $table->integer('department')->nullable()->default(null)->change();
            $table->integer('designation')->nullable()->default(null)->change();
            $table->integer('date_of_joining')->nullable()->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('developers', function (Blueprint $table) {
            //
        });
    }
};

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
            $table->string('developer_name')->nullable()->default(null)->change();
            $table->string('email')->nullable()->default(null)->change();
            $table->string('phone_number')->nullable()->default(null)->change();
            $table->string('department')->nullable()->default(null)->change();
            $table->string('designation')->nullable()->default(null)->change();
            $table->dateTime('date_of_joining')->nullable()->default(null)->change();
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

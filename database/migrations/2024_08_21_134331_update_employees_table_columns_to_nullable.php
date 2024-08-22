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
        Schema::table('employees', function (Blueprint $table) {
            $table->string('employee_id')->nullable()->change();
            $table->string('fullname')->nullable()->change();
            $table->string('department_id')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('role')->nullable()->change();
            $table->string('possition')->nullable()->change();
            $table->string('joining_date')->nullable()->change();
            $table->string('leaving_date')->nullable()->change();
            $table->string('status')->nullable()->change();
            $table->string('next_of_kin')->nullable()->change();
            $table->string('refference_contact')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nullable', function (Blueprint $table) {
            //
        });
    }
};

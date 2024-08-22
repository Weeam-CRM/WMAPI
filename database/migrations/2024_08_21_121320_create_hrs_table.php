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
        Schema::create('hrs', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('employee_id');
            $table->string('fullname');
            $table->string('department_id');
            $table->string('email');
            $table->string('role');
            $table->string('possition');
            $table->string('joining_date');
            $table->string('leaving_date');
            $table->string('status');
            $table->string('next_of_kin');
            $table->string('refference_contact');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hrs');
    }
};

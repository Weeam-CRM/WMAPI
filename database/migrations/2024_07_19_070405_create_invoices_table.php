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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->unsignedBigInteger('user_id');
            $table->string('unit_no')->nullable();
            $table->string('country')->nullable();
            $table->string('total_commission')->nullable();
            $table->string('claim_type')->nullable();
            $table->string('currency')->nullable();
            $table->string('vat_amount')->nullable();
            $table->string('comm_percent')->nullable();
            $table->string('status')->nullable();
            $table->string('paid_by')->nullable();
            $table->date('invoice_date');
            $table->decimal('total_amount', 10, 2);
            $table->text('notes')->nullable();
            $table->timestamps();

            // Define foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('installments')) {
            Schema::create('installments', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('credit_id');
                $table->bigInteger('amount');
                $table->date('payment_date');
                $table->boolean('paid')->default(0)->nullable(); // 0 not payed | 1 payed
                $table->timestamps();
            });

            Schema::table('installments', function ($table) {
                $table->foreign('credit_id')->references('id')->on('credits')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('installments');
    }
};

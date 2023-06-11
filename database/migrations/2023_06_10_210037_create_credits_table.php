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
        if (!Schema::hasTable('credits')) {
            Schema::create('credits', function (Blueprint $table) {
                $table->id();
                $table->uuid('code')->unique();
                $table->unsignedBigInteger('borrower_id');
                $table->bigInteger('amount');
                $table->bigInteger('installment_amount');
                $table->integer('term');
                $table->boolean('status')->default(0); // 0 - active | 1 - closed
                $table->timestamps();
            });

            Schema::table('credits', function ($table) {
                $table->foreign('borrower_id')->references('id')->on('borrowers')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credits');
    }
};

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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->decimal('amount', 10, 2); // Adjust precision and scale as needed
            $table->decimal('interest_rate', 5, 2); // Adjust precision and scale as needed
            $table->integer('sub_group_id');
            $table->integer('term');
            $table->string('payment_option');
            $table->decimal('loan_total', 10, 2);     
            $table->decimal('payment_amount', 10, 2);     
            $table->decimal('loan_interest', 10, 2); // Adjust precision and scale as needed
            $table->integer('quantity');
            $table->text('description')->nullable();
            $table->date('start_date');
            $table->boolean('approved')->default(false);
            $table->boolean('completed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};

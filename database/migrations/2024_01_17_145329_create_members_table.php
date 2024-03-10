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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sub_group_id')->nullable();
            $table->decimal('registration_fee', 8, 2);
            $table->date('registration_date');
            $table->string('id_number')->nullable();
            $table->string('name');
            $table->string('postal_address')->nullable(); // Add postal address field
            $table->string('residence')->nullable(); // Add residence field
            $table->string('town')->nullable(); // Add town field
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('photo')->nullable();
            $table->string('phone')->nullable();
            $table->enum('nationality', ['Kenyan', 'Foreign'])->default('Kenyan'); // Add nationality field
            $table->boolean('status')->default(true);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};

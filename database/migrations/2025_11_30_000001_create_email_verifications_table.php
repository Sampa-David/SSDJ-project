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
        Schema::create('email_verifications', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('verification_code'); // 6-digit code
            $table->string('temporary_password'); // Generated password
            $table->integer('attempts')->default(0); // Failed attempts counter
            $table->dateTime('expires_at'); // Code expiration time
            $table->timestamps();

            // Index for cleanup queries
            $table->index('expires_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_verifications');
    }
};

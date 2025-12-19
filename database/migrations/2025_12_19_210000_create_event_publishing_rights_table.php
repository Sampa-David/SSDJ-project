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
        Schema::create('event_publishing_rights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('package_type', ['monthly', 'quarterly', 'yearly']);
            $table->decimal('price', 8, 2);
            $table->enum('status', ['active', 'expired'])->default('active');
            $table->timestamp('purchased_at');
            $table->timestamp('expires_at');
            $table->string('payment_id');
            $table->timestamps();
            
            // Indexes
            $table->index('user_id');
            $table->index('status');
            $table->index('expires_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_publishing_rights');
    }
};

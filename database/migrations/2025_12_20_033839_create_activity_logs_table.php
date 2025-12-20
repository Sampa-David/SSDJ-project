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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('action')->comment('user_login, user_logout, ticket_purchased, ticket_used, user_created, user_deleted, event_created, etc');
            $table->string('description')->nullable();
            $table->string('model_type')->nullable()->comment('Model class that was acted upon');
            $table->unsignedBigInteger('model_id')->nullable()->comment('ID of the model that was acted upon');
            $table->json('changes')->nullable()->comment('What changed (old values, new values)');
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
            
            $table->index('user_id');
            $table->index('action');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};

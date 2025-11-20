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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('ticket_type', ['early_bird', 'regular', 'premium'])->default('regular');
            $table->decimal('price', 8, 2);
            $table->string('ticket_number')->unique();
            $table->string('status')->default('active'); // active, cancelled, used
            $table->datetime('purchased_at');
            $table->datetime('valid_from')->nullable();
            $table->datetime('valid_until')->nullable();
            $table->string('qr_code')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};

<?php

use App\Models\User;
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
        Schema::table('events', function (Blueprint $table) {
            // Add new columns if they don't exist
            if (!Schema::hasColumn('events', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            }
            if (!Schema::hasColumn('events', 'location')) {
                $table->string('location')->nullable();
            }
            if (!Schema::hasColumn('events', 'package_type')) {
                $table->enum('package_type', ['starter', 'professional', 'premium'])->nullable();
            }
            if (!Schema::hasColumn('events', 'price')) {
                $table->decimal('price', 8, 2)->nullable();
            }
            if (!Schema::hasColumn('events', 'status')) {
                $table->enum('status', ['draft', 'pending', 'published', 'expired'])->default('draft');
            }
            if (!Schema::hasColumn('events', 'published_at')) {
                $table->timestamp('published_at')->nullable();
            }
            if (!Schema::hasColumn('events', 'expires_at')) {
                $table->timestamp('expires_at')->nullable();
            }
            if (!Schema::hasColumn('events', 'payment_id')) {
                $table->string('payment_id')->nullable();
            }
            if (!Schema::hasColumn('events', 'visibility')) {
                $table->enum('visibility', ['public', 'private', 'friends'])->default('public');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeignIdFor(User::class, 'user_id');
            $table->dropColumn([
                'user_id',
                'location',
                'package_type',
                'price',
                'status',
                'published_at',
                'expires_at',
                'payment_id',
                'visibility'
            ]);
        });
    }
};

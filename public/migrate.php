<?php
/**
 * Migration Runner Script for Infinity Free
 * Access via: https://eventix.42web.io/migrate.php
 */

// Load Laravel
require __DIR__ . '/../bootstrap/app.php';

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

try {
    echo "<h2>🚀 Exécution des migrations...</h2>";
    echo "<hr>";

    // Migration 1: Create tickets table
    echo "<p><strong>Migration 1 : Création de la table 'tickets'...</strong></p>";
    
    if (!Schema::hasTable('tickets')) {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('ticket_type');
            $table->decimal('price', 8, 2);
            $table->string('ticket_number')->unique();
            $table->string('status')->default('active');
            $table->timestamp('purchased_at')->nullable();
            $table->timestamp('valid_from')->nullable();
            $table->timestamp('valid_until')->nullable();
            $table->longText('qr_code')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index('user_id');
        });
        echo "✅ Table 'tickets' créée avec succès !<br>";
    } else {
        echo "⚠️ Table 'tickets' existe déjà.<br>";
    }

    // Migration 2: Add phone and company columns to users table
    echo "<p><strong>Migration 2 : Ajout des colonnes 'phone' et 'company' à la table 'users'...</strong></p>";
    
    if (Schema::hasTable('users')) {
        if (!Schema::hasColumn('users', 'phone')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('phone')->nullable()->after('email');
            });
            echo "✅ Colonne 'phone' ajoutée avec succès !<br>";
        } else {
            echo "⚠️ Colonne 'phone' existe déjà.<br>";
        }

        if (!Schema::hasColumn('users', 'company')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('company')->nullable()->after('phone');
            });
            echo "✅ Colonne 'company' ajoutée avec succès !<br>";
        } else {
            echo "⚠️ Colonne 'company' existe déjà.<br>";
        }
    }

    echo "<hr>";
    echo "<p style='color: green; font-size: 18px;'><strong>✅ Toutes les migrations ont été exécutées avec succès !</strong></p>";
    echo "<p><a href='https://eventix.42web.io/login' style='padding: 10px 20px; background-color: #667eea; color: white; text-decoration: none; border-radius: 5px;'>Aller à la page de connexion</a></p>";

} catch (\Exception $e) {
    echo "<p style='color: red; font-size: 18px;'><strong>❌ Erreur lors de l'exécution des migrations :</strong></p>";
    echo "<pre style='background-color: #f0f0f0; padding: 10px; border-radius: 5px;'>";
    echo htmlspecialchars($e->getMessage());
    echo "</pre>";
}
?>

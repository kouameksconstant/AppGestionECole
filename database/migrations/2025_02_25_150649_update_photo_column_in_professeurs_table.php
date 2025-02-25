<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Appliquer la migration
     */
    public function up(): void
    {
        Schema::table('professeurs', function (Blueprint $table) {
            $table->string('photo', 255)->nullable()->change(); // Permet les valeurs NULL
        });
    }

    /**
     * Annuler la migration
     */
    public function down(): void
    {
        Schema::table('professeurs', function (Blueprint $table) {
            $table->string('photo', 255)->nullable(false)->change(); // Revenir à l'ancienne version
        });
    }
};

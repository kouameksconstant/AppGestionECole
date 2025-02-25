<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('professeur_matiere', function (Blueprint $table) {
            $table->integer('nb_heures')->default(0); // Ajout du nombre d'heures
        });
    }

    public function down(): void {
        Schema::table('professeur_matiere', function (Blueprint $table) {
            $table->dropColumn('nb_heures');
        });
    }
};

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
        Schema::table('professeur_matiere', function (Blueprint $table) {
            $table->integer('heures_effectuees')->default(0)->after('nb_heures');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('professeur_matiere', function (Blueprint $table) {
            $table->dropColumn('heures_effectuees');
        });
    }
};

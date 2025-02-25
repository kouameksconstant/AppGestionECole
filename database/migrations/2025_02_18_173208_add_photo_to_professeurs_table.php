<?php

// Exemple : 2025_02_18_123456_add_photo_to_professeurs_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPhotoToProfesseursTable extends Migration
{
    public function up()
    {
        Schema::table('professeurs', function (Blueprint $table) {
            $table->string('photo')->nullable(); // Ajout de la colonne 'photo'
        });
    }

    public function down()
    {
        Schema::table('professeurs', function (Blueprint $table) {
            $table->dropColumn('photo'); // Suppression de la colonne 'photo'
        });
    }
}

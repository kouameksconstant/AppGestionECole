<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('professeurs', function (Blueprint $table) {
        $table->string('photo')->nullable()->default('')->change(); // Ajoutez 'default' pour la photo vide
    });
}

public function down()
{
    Schema::table('professeurs', function (Blueprint $table) {
        $table->string('photo')->nullable(false)->change(); // Pour annuler la modification
    });
}

};

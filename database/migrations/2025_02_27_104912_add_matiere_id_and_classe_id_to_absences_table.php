<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMatiereIdAndClasseIdToAbsencesTable extends Migration
{
    public function up()
    {
        Schema::table('absences', function (Blueprint $table) {
            $table->unsignedBigInteger('matiere_id')->after('professeur_id');
            $table->unsignedBigInteger('classe_id')->after('matiere_id');

            $table->foreign('matiere_id')->references('id')->on('matieres')->onDelete('cascade');
            $table->foreign('classe_id')->references('id')->on('classes')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('absences', function (Blueprint $table) {
            $table->dropForeign(['matiere_id']);
            $table->dropForeign(['classe_id']);
            $table->dropColumn(['matiere_id', 'classe_id']);
        });
    }
}

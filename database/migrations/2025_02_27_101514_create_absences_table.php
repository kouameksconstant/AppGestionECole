<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absences', function (Blueprint $table) {
            $table->id();
            // Si la table 'professeurs' utilise bigIncrements pour l'id, utilisez unsignedBigInteger
            $table->unsignedBigInteger('professeur_id');
            $table->date('date_absence');
            $table->integer('duree'); // par exemple, en heures
            $table->text('motif')->nullable();
            $table->string('statut', 50)->default('en attente');
            $table->string('justificatif', 255)->nullable();
            $table->timestamps();

            // Définir la clé étrangère
            $table->foreign('professeur_id')
                  ->references('id')->on('professeurs')
                  ->onDelete('cascade'); // optionnel : pour supprimer les absences si le professeur est supprimé
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('absences');
    }
}

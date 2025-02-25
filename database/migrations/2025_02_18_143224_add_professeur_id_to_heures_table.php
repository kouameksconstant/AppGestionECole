<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfesseurIdToHeuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('heures', function (Blueprint $table) {
            $table->unsignedBigInteger('professeur_id')->after('id');

            // Si vous utilisez des clés étrangères, ajoutez la contrainte de clé étrangère
            $table->foreign('professeur_id')->references('id')->on('professeurs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('heures', function (Blueprint $table) {
            $table->dropForeign(['professeur_id']);
            $table->dropColumn('professeur_id');
        });
    }
}

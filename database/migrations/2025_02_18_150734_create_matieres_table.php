<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMatiereIdToHeuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('heures', function (Blueprint $table) {
            if (!Schema::hasColumn('heures', 'matiere_id')) {
                $table->unsignedBigInteger('matiere_id')->nullable();
                $table->foreign('matiere_id')->references('id')->on('matieres')->onDelete('cascade');
            }
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
            if (Schema::hasColumn('heures', 'matiere_id')) {
                $table->dropForeign(['matiere_id']);
                $table->dropColumn('matiere_id');
            }
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDetailsToHeuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('heures', function (Blueprint $table) {
            if (!Schema::hasColumn('heures', 'matiere')) {
                $table->string('matiere')->nullable();
            }
            if (!Schema::hasColumn('heures', 'nombre_heures')) {
                $table->integer('nombre_heures')->nullable();
            }
            if (!Schema::hasColumn('heures', 'heure')) {
                $table->time('heure')->nullable();
            }
            if (!Schema::hasColumn('heures', 'date_debut')) {
                $table->date('date_debut')->nullable();
            }
            if (!Schema::hasColumn('heures', 'date_fin')) {
                $table->date('date_fin')->nullable();
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
            if (Schema::hasColumn('heures', 'matiere')) {
                $table->dropColumn('matiere');
            }
            if (Schema::hasColumn('heures', 'nombre_heures')) {
                $table->dropColumn('nombre_heures');
            }
            if (Schema::hasColumn('heures', 'heure')) {
                $table->dropColumn('heure');
            }
            if (Schema::hasColumn('heures', 'date_debut')) {
                $table->dropColumn('date_debut');
            }
            if (Schema::hasColumn('heures', 'date_fin')) {
                $table->dropColumn('date_fin');
            }
        });
    }
}

<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterClassesTable extends Migration
{
    public function up()
    {
        Schema::table('classes', function (Blueprint $table) {
            // S'assurer que la colonne `id` est présente comme clé primaire
            $table->bigIncrements('id')->change();
        });
    }

    public function down()
    {
        Schema::table('classes', function (Blueprint $table) {
            $table->dropColumn('id');
        });
    }
}

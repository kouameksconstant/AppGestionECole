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
        Schema::table('students', function (Blueprint $table) {
            // Ajout de la colonne filiere_id
            $table->unsignedBigInteger('filiere_id')->nullable();

            // Définition de la clé étrangère pour filiere_id
            $table->foreign('filiere_id')->references('id')->on('filieres')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            // Suppression de la clé étrangère
            $table->dropForeign(['filiere_id']);
            
            // Suppression de la colonne filiere_id
            $table->dropColumn('filiere_id');
        });
    }
};

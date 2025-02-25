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
        Schema::create('professeur_matiere', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professeur_id')
                ->constrained('professeurs') // Assure la correspondance avec la table correcte
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreignId('matiere_id')
                ->constrained('matieres') 
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreignId('classe_id')
                ->constrained('classes') 
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->timestamps();

            // Ajout d'une contrainte d'unicité pour éviter les doublons
            $table->unique(['professeur_id', 'matiere_id', 'classe_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professeur_matiere');
    }
};

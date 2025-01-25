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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
        // Pour recupérer la table posts
        Schema::table('posts', function (Blueprint $table){
            //Cette méthode indique que si une entrée dans la table categories est supprimée, toutes les entrées correspondantes dans la table posts seront également supprimées (cascade).
            $table -> foreignIdFor(\App\Models\Category::class)->nullable()->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
        Schema::table('posts', function(Blueprint $table){
            $table->dropForeignIdFor(\App\Models\Category::class);
        });
    }
};

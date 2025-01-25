<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Cette migration nous permet d'avoir une colonne image dans notre table posts
     */
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table -> string('image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            //Au cas où on souhaite l'inverser
            $table->dropColumn('image');
        });
    }
};

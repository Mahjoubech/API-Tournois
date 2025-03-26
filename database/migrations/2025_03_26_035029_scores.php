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
      Schema::create('scores',function(Blueprint $table){
          $table->id();
          $table->foreignId('user_id')->constrained()->onDelete('cascade');
          $table->foreignId('player1_id')->constrained('players')->onDelete('cascade'); 
          $table->foreignId('player2_id')->constrained('players')->onDelete('cascade'); 
          $table->foreignId('match_id')->constrained('matches')->onDelete('cascade');
          $table->integer('player1_score')->default(0);
          $table->integer('player2_score')->default(0);
          $table->timestamps();
          $table->unique(['match_id']);
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scores');
    }
};

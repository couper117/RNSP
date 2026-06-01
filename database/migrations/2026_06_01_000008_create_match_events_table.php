<?php

namespace Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('match_events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fixture_id');
            $table->enum('event_type', ['goal', 'red_card', 'yellow_card', 'substitution', 'injury', 'end_match', 'start_match'])->default('goal');
            $table->unsignedBigInteger('player_id')->nullable();
            $table->unsignedBigInteger('replacement_player_id')->nullable();
            $table->integer('minute');
            $table->enum('team_side', ['home', 'away']);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('fixture_id')->references('id')->on('fixtures')->onDelete('cascade');
            $table->foreign('player_id')->references('id')->on('players')->onDelete('set null');
            $table->foreign('replacement_player_id')->references('id')->on('players')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('match_events');
    }
};

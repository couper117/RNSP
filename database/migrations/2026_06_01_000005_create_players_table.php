<?php

namespace Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('jersey_number');
            $table->date('date_of_birth');
            $table->enum('position', ['goalkeeper', 'defender', 'midfielder', 'forward'])->default('midfielder');
            $table->unsignedBigInteger('team_id');
            $table->unsignedBigInteger('federation_id');
            $table->string('national_id')->nullable();
            $table->string('passport_number')->nullable();
            $table->string('photo_url')->nullable();
            $table->enum('status', ['pending', 'verified', 'suspended', 'inactive'])->default('pending');
            $table->timestamps();

            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->foreign('federation_id')->references('id')->on('federations')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};

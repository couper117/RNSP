<?php

namespace Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leagues', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('federation_id');
            $table->year('season');
            $table->enum('status', ['planning', 'active', 'completed', 'cancelled'])->default('planning');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('total_teams')->default(0);
            $table->integer('total_fixtures')->default(0);
            $table->timestamps();

            $table->foreign('federation_id')->references('id')->on('federations')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leagues');
    }
};

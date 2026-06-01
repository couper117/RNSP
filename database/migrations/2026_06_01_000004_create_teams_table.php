<?php

namespace Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('code', 10)->unique();
            $table->unsignedBigInteger('federation_id');
            $table->unsignedBigInteger('league_id')->nullable();
            $table->string('logo_url')->nullable();
            $table->text('description')->nullable();
            $table->string('coach_name')->nullable();
            $table->string('coach_email')->nullable();
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->timestamps();

            $table->foreign('federation_id')->references('id')->on('federations')->onDelete('cascade');
            $table->foreign('league_id')->references('id')->on('leagues')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};

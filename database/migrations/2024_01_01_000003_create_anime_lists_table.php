<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anime_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('genre');
            $table->string('status'); // Watching, Completed, Plan to Watch, Dropped
            $table->integer('episodes')->default(0);
            $table->tinyInteger('rating')->nullable(); // 1-10
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anime_lists');
    }
};

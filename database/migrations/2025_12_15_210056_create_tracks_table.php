<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
{
    Schema::create('tracks', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('artist');
        $table->foreignId('genre_id')->constrained()->onDelete('cascade');
        $table->string('cover_path')->nullable(); // Путь к картинке
        $table->string('file_path');              // Путь к MP3
        $table->integer('year')->default(2024);
        $table->boolean('is_premium')->default(false);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tracks');
    }
};

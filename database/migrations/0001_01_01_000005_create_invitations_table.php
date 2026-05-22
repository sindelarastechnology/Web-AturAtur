<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->smallInteger('theme_id')->unsigned();
            $table->string('slug', 100)->unique()->comment('URL: aturatur.com/{slug}');
            $table->string('title', 150)->comment('Misal: Pernikahan Figa & Iskhand');
            $table->string('groom_name', 100)->nullable();
            $table->string('groom_nickname', 50)->nullable();
            $table->string('groom_father', 100)->nullable();
            $table->string('groom_mother', 100)->nullable();
            $table->string('groom_photo', 255)->nullable();
            $table->string('bride_name', 100)->nullable();
            $table->string('bride_nickname', 50)->nullable();
            $table->string('bride_father', 100)->nullable();
            $table->string('bride_mother', 100)->nullable();
            $table->string('bride_photo', 255)->nullable();
            $table->string('cover_photo', 255)->nullable()->comment('Foto sampul/hero undangan');
            $table->text('love_story')->nullable()->comment('Kisah cinta / caption singkat');
            $table->text('opening_quote')->nullable()->comment('Ayat / quote pembuka undangan');
            $table->string('music_url', 255)->nullable()->comment('URL musik latar (YouTube embed / file)');
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('view_count')->default(0);
            $table->timestamps();

            $table->index('theme_id');
            $table->foreign('theme_id')->references('id')->on('themes')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};

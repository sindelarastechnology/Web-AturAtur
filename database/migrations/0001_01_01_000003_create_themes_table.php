<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('themes', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('name', 100);
            $table->string('slug', 100)->unique()->comment('Nama folder blade: resources/views/themes/{slug}');
            $table->string('preview_image', 255)->nullable();
            $table->string('color_palette', 100)->nullable()->comment('Deskripsi warna misal: hijau sage, krem');
            $table->boolean('is_premium')->default(false);
            $table->boolean('is_active')->default(true);
            $table->smallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('themes');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('package_theme', function (Blueprint $table) {
            $table->tinyInteger('package_id')->unsigned();
            $table->smallInteger('theme_id')->unsigned();
            $table->primary(['package_id', 'theme_id']);
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
            $table->foreign('theme_id')->references('id')->on('themes')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('package_theme');
    }
};

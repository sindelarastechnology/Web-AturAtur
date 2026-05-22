<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained()->cascadeOnDelete();
            $table->string('type', 20)->default('resepsi')->comment('akad, resepsi, lainnya');
            $table->string('title', 100)->comment('Misal: Akad Nikah, Resepsi');
            $table->date('date');
            $table->time('time_start');
            $table->time('time_end')->nullable();
            $table->string('venue_name', 150)->nullable()->comment('Nama gedung / tempat');
            $table->text('address')->nullable();
            $table->string('maps_url', 500)->nullable()->comment('Google Maps embed / link');
            $table->text('maps_embed')->nullable()->comment('iframe embed code (opsional)');
            $table->tinyInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};

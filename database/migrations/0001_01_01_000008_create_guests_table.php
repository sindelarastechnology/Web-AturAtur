<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained()->cascadeOnDelete();
            $table->string('name', 150)->comment('Nama lengkap tamu');
            $table->string('slug', 200)->comment('URL-friendly: Budi-Sudarsono');
            $table->string('phone', 20)->nullable()->comment('Untuk kirim link via WA');
            $table->string('group_label', 100)->nullable()->comment('Misal: Keluarga Pria, Rekan Kerja');
            $table->string('rsvp_status', 20)->default('pending')->comment('pending, hadir, tidak_hadir, mungkin');
            $table->timestamp('rsvp_at')->nullable();
            $table->tinyInteger('guest_count')->unsigned()->default(1)->comment('Jumlah orang yang hadir');
            $table->timestamp('checked_in_at')->nullable();
            $table->timestamps();

            $table->unique(['invitation_id', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};

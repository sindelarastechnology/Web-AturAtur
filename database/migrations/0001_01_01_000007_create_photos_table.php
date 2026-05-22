<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained()->cascadeOnDelete();
            $table->string('filename', 255)->comment('Nama file tersimpan di storage');
            $table->string('original_name', 255)->nullable()->comment('Nama file asli saat upload');
            $table->smallInteger('size_kb')->unsigned()->nullable()->comment('Ukuran file dalam KB');
            $table->string('type', 20)->default('gallery')->comment('gallery, couple, cover');
            $table->tinyInteger('sort_order')->default(0);
            $table->timestamp('created_at')->useCurrent();

            $table->index('invitation_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('photos');
    }
};

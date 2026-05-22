<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('name', 50);
            $table->string('slug', 50)->unique();
            $table->tinyInteger('max_photos')->default(5);
            $table->smallInteger('max_guests')->default(50)->comment('-1 = unlimited');
            $table->smallInteger('duration_days')->default(90)->comment('-1 = selamanya');
            $table->string('price_display', 20)->default('Rp0');
            $table->text('wa_template')->nullable()->comment('Template pesan order WA');
            $table->json('features')->nullable()->comment('Fitur tambahan sebagai array string');
            $table->boolean('is_active')->default(true);
            $table->tinyInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};

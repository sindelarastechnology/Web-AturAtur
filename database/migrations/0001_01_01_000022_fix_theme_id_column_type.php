<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedSmallInteger('theme_id')->nullable()->change();
        });

        try {
            Schema::table('users', function (Blueprint $table) {
                $table->foreign('theme_id')->references('id')->on('themes')->nullOnDelete();
            });
        } catch (\Exception $e) {
            // Foreign key may already exist
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['theme_id']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->bigInteger('theme_id')->unsigned()->nullable()->change();
        });
    }
};

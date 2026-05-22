<?php

use App\Models\Invitation;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->string('groom_slug', 100)->nullable()->after('groom_name');
            $table->string('bride_slug', 100)->nullable()->after('bride_name');
        });

        Invitation::all()->each(function (Invitation $invitation) {
            $invitation->groom_slug = Str::slug($invitation->groom_name ?? '');
            $invitation->bride_slug = Str::slug($invitation->bride_name ?? '');
            $invitation->save();
        });
    }

    public function down(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->dropColumn(['groom_slug', 'bride_slug']);
        });
    }
};

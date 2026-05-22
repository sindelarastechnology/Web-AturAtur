<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Invitation extends Model
{
    protected $fillable = [
        'user_id',
        'theme_id',
        'slug',
        'title',
        'groom_name',
        'groom_slug',
        'groom_nickname',
        'groom_father',
        'groom_mother',
        'groom_photo',
        'bride_name',
        'bride_slug',
        'bride_nickname',
        'bride_father',
        'bride_mother',
        'bride_photo',
        'cover_photo',
        'love_story',
        'opening_quote',
        'music_url',
        'bank_name',
        'bank_account',
        'custom_css',
        'custom_colors',
        'is_active',
        'view_count',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'view_count' => 'integer',
            'custom_colors' => 'array',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function (Invitation $invitation) {
            if ($invitation->isDirty('groom_name') || !$invitation->groom_slug) {
                $invitation->groom_slug = Str::slug($invitation->groom_name ?? '');
            }
            if ($invitation->isDirty('bride_name') || !$invitation->bride_slug) {
                $invitation->bride_slug = Str::slug($invitation->bride_name ?? '');
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function guests()
    {
        return $this->hasMany(Guest::class);
    }

    public function wishes()
    {
        return $this->hasMany(Wish::class);
    }
}

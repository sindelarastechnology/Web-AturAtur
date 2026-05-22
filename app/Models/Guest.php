<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    protected $fillable = [
        'invitation_id',
        'name',
        'slug',
        'phone',
        'group_label',
        'rsvp_status',
        'rsvp_at',
        'guest_count',
        'checked_in_at',
    ];

    protected function casts(): array
    {
        return [
            'rsvp_at' => 'datetime',
            'guest_count' => 'integer',
            'checked_in_at' => 'datetime',
        ];
    }

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }

    public function wishes()
    {
        return $this->hasMany(Wish::class);
    }

    public function gift()
    {
        return $this->hasOne(Gift::class);
    }
}

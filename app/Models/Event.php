<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'invitation_id',
        'type',
        'title',
        'date',
        'time_start',
        'time_end',
        'venue_name',
        'address',
        'maps_url',
        'maps_embed',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'sort_order' => 'integer',
        ];
    }

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }
}

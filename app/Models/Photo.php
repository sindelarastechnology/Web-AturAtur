<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'invitation_id',
        'filename',
        'original_name',
        'size_kb',
        'type',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'size_kb' => 'integer',
            'sort_order' => 'integer',
            'created_at' => 'datetime',
        ];
    }

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }
}

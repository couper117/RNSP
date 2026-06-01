<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlayerDocument extends Model
{
    protected $fillable = [
        'player_id',
        'document_type',
        'document_url',
        'status',
        'rejection_reason',
        'reviewed_by',
        'reviewed_at',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function reviewedBy()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}

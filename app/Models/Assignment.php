<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = [
        'user_id',
        'role',
        'federation_id',
        'league_id',
        'assigned_by',
        'status',
        'accepted_at',
        'notes',
    ];

    protected $casts = [
        'accepted_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function federation()
    {
        return $this->belongsTo(Federation::class);
    }

    public function league()
    {
        return $this->belongsTo(League::class);
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
}

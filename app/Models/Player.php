<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'jersey_number',
        'date_of_birth',
        'position',
        'team_id',
        'federation_id',
        'national_id',
        'passport_number',
        'photo_url',
        'status',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function federation()
    {
        return $this->belongsTo(Federation::class);
    }

    public function documents()
    {
        return $this->hasMany(PlayerDocument::class);
    }

    public function matchEvents()
    {
        return $this->hasMany(MatchEvent::class);
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}

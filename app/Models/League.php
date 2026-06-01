<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    protected $fillable = [
        'name',
        'description',
        'federation_id',
        'season',
        'status',
        'start_date',
        'end_date',
        'total_teams',
        'total_fixtures',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function federation()
    {
        return $this->belongsTo(Federation::class);
    }

    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    public function fixtures()
    {
        return $this->hasMany(Fixture::class);
    }

    public function standings()
    {
        return $this->hasMany(Standing::class);
    }
}

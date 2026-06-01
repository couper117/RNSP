<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fixture extends Model
{
    protected $fillable = [
        'league_id',
        'home_team_id',
        'away_team_id',
        'fixture_date',
        'venue',
        'status',
        'home_goals',
        'away_goals',
        'match_reporter_id',
        'match_week',
    ];

    protected $casts = [
        'fixture_date' => 'datetime',
    ];

    public function league()
    {
        return $this->belongsTo(League::class);
    }

    public function homeTeam()
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function awayTeam()
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }

    public function matchReporter()
    {
        return $this->belongsTo(User::class, 'match_reporter_id');
    }

    public function events()
    {
        return $this->hasMany(MatchEvent::class);
    }
}

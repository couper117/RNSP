<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MatchEvent extends Model
{
    protected $table = 'match_events';

    protected $fillable = [
        'fixture_id',
        'event_type',
        'player_id',
        'replacement_player_id',
        'minute',
        'team_side',
        'description',
    ];

    public function fixture()
    {
        return $this->belongsTo(Fixture::class);
    }

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function replacementPlayer()
    {
        return $this->belongsTo(Player::class, 'replacement_player_id');
    }
}

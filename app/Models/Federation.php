<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Federation extends Model
{
    protected $fillable = [
        'name',
        'acronym',
        'description',
        'logo_url',
        'website',
        'email',
        'phone',
        'status',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function leagues()
    {
        return $this->hasMany(League::class);
    }

    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    public function players()
    {
        return $this->hasMany(Player::class);
    }
}

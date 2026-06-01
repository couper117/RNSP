<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'federation_id',
        'league_id',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'email_verified_at' => 'datetime',
    ];

    public function federation()
    {
        return $this->belongsTo(Federation::class);
    }

    public function league()
    {
        return $this->belongsTo(League::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }
}

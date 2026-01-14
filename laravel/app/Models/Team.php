<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = 'SAN_TEAMS';
    protected $primaryKey = 'TEA_ID';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'USE_ID',      // owner id (FK SAN_USERS.USE_ID)
        'TEA_NAME',
        'TEA_IMAGE',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'USE_ID', 'USE_ID');
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'SAN_USERS_TEAMS', 'TEA_ID', 'USE_ID');
    }

    public function races()
    {
        return $this->belongsToMany(Race::class, 'SAN_TEAMS_RACES', 'TEA_ID', 'RAC_ID')
            ->withPivot(['TER_TIME', 'TER_IS_VALID', 'TER_RACE_NUMBER']);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class User extends Model
{

    use HasApiTokens;

    protected $table = 'SAN_USERS';
    protected $primaryKey = 'USE_ID';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'ADD_ID',
        'CLU_ID',
        'USE_MAIL',
        'USE_PASSWORD',
        'USE_NAME',
        'USE_LAST_NAME',
        'USE_BIRTHDATE',
        'USE_PHONE_NUMBER',
        'USE_LICENCE_NUMBER',
        'USE_PPS_FORM',
        'USE_MEMBERSHIP_DATE',
    ];

    protected $hidden = [
        'USE_PASSWORD',
    ];

    protected $casts = [
        'USE_BIRTHDATE'       => 'date',
        'USE_MEMBERSHIP_DATE' => 'date',
        'USE_PASSWORD'        => 'hashed',
    ];

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'ADD_ID', 'ADD_ID');
    }

    public function club(): BelongsTo
    {
        return $this->belongsTo(Club::class, 'CLU_ID', 'CLU_ID');
    }

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(
            Team::class,
            'SAN_USERS_TEAMS',
            'USE_ID',
            'TEA_ID'
        );
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(
            Role::class,
            'SAN_ROLES_USERS',
            'USE_ID',
            'ROL_ID'
        );
    }

    public function races(): BelongsToMany
    {
        return $this->belongsToMany(
            Race::class,
            'SAN_USERS_RACES',
            'USE_ID',
            'RAC_ID'
        );
    }

    public function teamsCreated(): HasMany
    {
        return $this->hasMany(Team::class, 'USE_ID', 'USE_ID');
    }

    public function clubsCreated(): HasMany
    {
        return $this->hasMany(Club::class, 'USE_ID', 'USE_ID');
    }

    public function racesCreated(): HasMany
    {
        return $this->hasMany(Race::class, 'USE_ID', 'USE_ID');
    }

    public function raidsCreated(): HasMany
    {
        return $this->hasMany(Raid::class, 'USE_ID', 'USE_ID');
    }
}

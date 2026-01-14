<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Race extends Model
{
    use HasFactory;

    protected $table = 'SAN_RACES';
    public $timestamps = false;
    protected $primaryKey = 'RAC_ID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'USE_ID', 
        'RAI_ID', 
        'RAC_TIME_START', 
        'RAC_TIME_END', 
        'RAC_GENDER',
        'RAC_TYPE', 
        'RAC_DIFFICULTY', 
        'RAC_MIN_PARTICIPANTS', 
        'RAC_MAX_PARTICIPANTS', 
        'RAC_MIN_TEAMS', 
        'RAC_MAX_TEAMS', 
        'RAC_MAX_TEAM_MEMBERS', 
        'RAC_AGE_MIN', 
        'RAC_AGE_MIDDLE', 
        'RAC_AGE_MAX'
    ];

    public function races(): HasMany
    {
        return $this->hasMany(self::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'USE_ID', 'USE_ID');
    }

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(
            Team::class,
            'SAN_TEAMS_RACES',
            'RAC_ID',
            'TEA_ID'
        )->withPivot('TER_TIME', 'TER_IS_VALID', 'TER_RACE_NUMBER');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(
            Category::class,
            'SAN_CATEGORIES_RACES',
            'RAC_ID',
            'CAT_ID'
        )->withPivot('CAR_PRICE');
    }
}
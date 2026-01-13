<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'RAC_TYPE', 
        'RAC_DIFFICULTY', 
        'RAC_MIN_PARTICIPANTS', 
        'RAC_MAX_PARTICIPANTS', 
        'RAC_MIN_TEAMS', 
        'RAC_MAX_TEAMS', 
        'RAC_TEAM_MEMBERS', 
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
}
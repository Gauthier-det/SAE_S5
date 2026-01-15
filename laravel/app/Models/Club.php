<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Club extends Model
{
    use HasFactory;

    protected $table = 'SAN_CLUBS';
    public $timestamps = false;
    protected $primaryKey = 'CLU_ID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'USE_ID',
        'ADD_ID',
        'CLU_NAME'
    ];

    public function clubs(): HasMany
    {
        return $this->hasMany(self::class);
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'ADD_ID', 'ADD_ID');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'USE_ID', 'USE_ID');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'CLU_ID', 'CLU_ID');
    }
}
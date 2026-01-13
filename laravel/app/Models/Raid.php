<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Raid extends Model
{
    protected $table = 'SAN_RAIDS';
    protected $primaryKey = 'RAI_ID';
    public $timestamps = false;
    
    protected $fillable = [
        'CLU_ID',
        'ADD_ID',
        'USE_ID',
        'RAI_NAME',
        'RAI_MAIL',
        'RAI_PHONE_NUMBER',
        'RAI_WEB_SITE',
        'RAI_IMAGE',
        'RAI_TIME_START',
        'RAI_TIME_END',
        'RAI_REGISTRATION_START',
        'RAI_REGISTRATION_END',
    ];

    protected $casts = [
        'RAI_TIME_START'         => 'datetime',
        'RAI_TIME_END'           => 'datetime',
        'RAI_REGISTRATION_START' => 'datetime',
        'RAI_REGISTRATION_END'   => 'datetime',
    ];

    public function club(): BelongsTo
    {
        return $this->belongsTo(Club::class, 'CLU_ID', 'CLU_ID');
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'ADD_ID', 'ADD_ID');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'USE_ID', 'USE_ID');
    }
}
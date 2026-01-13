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

    public function races(): HasMany
    {
        return $this->hasMany(self::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Address extends Model
{
    use HasFactory;

    protected $table = 'SAN_ADDRESSES';
    public $timestamps = false;
    protected $primaryKey = 'ADD_ID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'ADD_POSTAL_CODE',
        'ADD_CITY',
        'ADD_STREET_NAME',
        'ADD_STREET_NUMBER'
    ];
    public function addresses(): HasMany
    {
        return $this->hasMany(self::class);
    }


}
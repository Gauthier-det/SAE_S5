<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

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

    /**
     * Get all raids at this address.
     */
    public function raids(): HasMany
    {
        return $this->hasMany(Raid::class, 'ADD_ID', 'ADD_ID');
    }

    /**
     * Get all users at this address.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'ADD_ID', 'ADD_ID');
    }
}

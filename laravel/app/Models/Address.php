<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'SAN_ADDRESSES';
    protected $primaryKey = 'ADD_ID';
    public $timestamps = false;
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'ADD_POSTAL_CODE',
        'ADD_CITY',
        'ADD_STREET_NAME',
        'ADD_STREET_NUMBER',
    ];
}

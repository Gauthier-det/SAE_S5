<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    protected $table = 'SAN_CATEGORIES';
    public $timestamps = false;
    protected $primaryKey = 'CAT_ID';
    public $incrementing = true;

    protected $fillable = [
        'CAT_LABEL',
    ];

    public function races(): BelongsToMany
    {
        return $this->belongsToMany(
            Race::class,
            'SAN_CATEGORIES_RACES',
            'CAT_ID',
            'RAC_ID'
        )->withPivot('CAR_PRICE');
    }
}

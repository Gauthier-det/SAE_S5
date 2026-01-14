<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    protected $table = 'SAN_ROLES';

    protected $primaryKey = 'ROL_ID';

    public $timestamps = false;

    protected $fillable = [
        'ROL_NAME',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'SAN_ROLES_USERS',
            'ROL_ID',
            'USE_ID'
        );
    }
}
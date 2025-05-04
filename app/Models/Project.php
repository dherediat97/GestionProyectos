<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //
    protected $fillable = [
        'name',
        'active',
        'created_at',
        'user_id',
        'updated_at',
    ];

    protected $hidden = [
        'id',
    ];
}

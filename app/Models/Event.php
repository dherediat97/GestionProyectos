<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'text',
        'project_id',
        'start_date',
        'end_date',
        'id',
    ];

    protected $hidden = [];
}

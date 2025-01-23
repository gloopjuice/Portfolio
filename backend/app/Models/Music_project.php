<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Music_project extends Model
{
    protected $fillable = [
        'musicprojectname',
        'musicprojectdescription',
        'musicprojectpicture',
    ];
}

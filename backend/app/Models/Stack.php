<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stack extends Model
{
    protected $table = 'stack'; 

    protected $casts = [
        'stackpicture' => 'string',
    ];

    protected $fillable = [
        'stackname',
        'stackdescription',
        'stackpicture',
    ];
}

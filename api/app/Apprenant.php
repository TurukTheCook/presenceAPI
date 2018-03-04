<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apprenant extends Model
{
    protected $fillable = [
        'first_name', 'last_name', 'avatar', 'sign',
    ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IndividualPresence extends Model
{
    protected $fillable = [
        'apprenant_id', 'presence_id', 'absent_matin', 'absent_aprem',
    ];
}

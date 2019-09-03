<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Director extends Model
{
    protected $fillable = [
        'name', 'date_of_birth', 'date_of_death', 'oscar',
    ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    protected $fillable = [
        'name', 'date_of_birth', 'date_of_death', 'oscar',
    ];

    public function films()
    {
        return $this->belongsToMany(Film::class);
    }
}

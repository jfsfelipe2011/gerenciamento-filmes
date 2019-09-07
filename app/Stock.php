<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = [
        'value', 'quantity', 'film_id'
    ];

    public function film()
    {
        return $this->belongsTo(Film::class);
    }
}

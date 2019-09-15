<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Director extends Model
{
    protected $fillable = [
        'name', 'date_of_birth', 'date_of_death', 'oscar',
    ];

    public function films()
    {
        return $this->belongsToMany(Film::class);
    }

    public function getDateOfBirthFormattedAttribute()
    {
        return (new \DateTime($this->date_of_birth))->format('d/m/Y');
    }

    public function getDateOfDeathFormattedAttribute()
    {
        return is_null($this->date_of_death) ? '-' : (new \DateTime($this->date_of_birth))
            ->format('d/m/Y');
    }
}

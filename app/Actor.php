<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Actor
 * @package App
 */
class Actor extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'date_of_birth', 'date_of_death', 'oscar',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function films()
    {
        return $this->belongsToMany(Film::class);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getDateOfBirthFormattedAttribute()
    {
        return (new \DateTime($this->date_of_birth))->format('d/m/Y');
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getDateOfDeathFormattedAttribute()
    {
        return is_null($this->date_of_death) ? '-' : (new \DateTime($this->date_of_birth))
            ->format('d/m/Y');
    }
}

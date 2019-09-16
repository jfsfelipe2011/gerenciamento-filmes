<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Stock
 * @package App
 */
class Stock extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'value', 'quantity', 'film_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function film()
    {
        return $this->belongsTo(Film::class);
    }
}

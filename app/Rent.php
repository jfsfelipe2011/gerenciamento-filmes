<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    const STATUS_RENTED   = 'rented';
    const STATUS_FINISHED = 'finished';
    const STATUS_LATE     = 'late';

    const VALID_STATUS = [
        self::STATUS_RENTED,
        self::STATUS_FINISHED,
        self::STATUS_LATE
    ];

    protected $fillable = [
        'start_date', 'end_date', 'status', 'value', 'customer_id'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function films()
    {
        return $this->belongsToMany(Film::class);
    }
}

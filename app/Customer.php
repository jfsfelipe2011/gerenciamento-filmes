<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    const CREDIT_CARD = 'credit-card';
    const BILLET      = 'billet';

    const VALID_PAYMENTS = [
        self::CREDIT_CARD,
        self::BILLET
    ];

    protected $fillable = [
        'name', 'address', 'document', 'payment'
    ];

    public function rents()
    {
        return $this->hasMany(Rent::class);
    }
}

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

    public function getDocumentFormattedAttribute()
    {
        return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/','$1.$2.$3-$4', $this->document);
    }

    public function getPaymentFormattedAttribute()
    {
        return $this->payment === self::BILLET ? 'Boleto' : 'Cartão de Crédito';
    }
}

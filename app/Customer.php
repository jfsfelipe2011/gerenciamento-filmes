<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Customer
 * @package App
 */
class Customer extends Model
{
    /** @var string */
    const CREDIT_CARD = 'credit-card';

    /** @var string */
    const BILLET      = 'billet';

    /** @var array */
    const VALID_PAYMENTS = [
        self::CREDIT_CARD,
        self::BILLET
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'address', 'document', 'payment'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rents()
    {
        return $this->hasMany(Rent::class);
    }

    /**
     * @return string|string[]|null
     */
    public function getDocumentFormattedAttribute()
    {
        return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/','$1.$2.$3-$4', $this->document);
    }

    /**
     * @return string
     */
    public function getPaymentFormattedAttribute()
    {
        return $this->payment === self::BILLET ? 'Boleto' : 'Cartão de Crédito';
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    const STATUS_RENTED   = 'rented';
    const STATUS_FINISHED = 'finished';
    const STATUS_LATE     = 'late';
    const STATUS_CANCELED = 'canceled';

    const VALID_STATUS = [
        self::STATUS_RENTED,
        self::STATUS_FINISHED,
        self::STATUS_LATE,
        self::STATUS_CANCELED
    ];

    protected $fillable = [
        'start_date', 'end_date', 'delivery_date', 'status', 'value', 'customer_id'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function films()
    {
        return $this->belongsToMany(Film::class);
    }

    public function getStartDateFormattedAttribute()
    {
        return (new \DateTime($this->start_date))->format('d/m/Y');
    }

    public function getEndDateFormattedAttribute()
    {
        return (new \DateTime($this->end_date))->format('d/m/Y');
    }

    public function getDeliveryDateFormattedAttribute()
    {
        return is_null($this->delivery_date) ? '-' : (new \DateTime($this->delivery_date))
            ->format('d/m/Y');
    }

    public function daysOfDelay()
    {
        if ($this->status === self::STATUS_CANCELED) {
            return 0;
        }

        $endDate = new \DateTime($this->end_date);

        if (is_null($this->delivery_date)) {
            $now = new \DateTime();

            $interval = $now->diff($endDate);
            $days     = (int) $interval->format('%R%a');

            return $days < 0 ? $days * -1 : 0;
        }

        $deliveryDate = new \DateTime($this->delivery_date);

        $interval = $deliveryDate->diff($endDate);
        $days     = (int) $interval->format('%R%a');

        return $days < 0 ? $days * -1 : 0;
    }

    public function daysOfRent()
    {
        $start_Date = new \DateTime($this->start_date);
        $endDate    = new \DateTime($this->end_date);

        $interval = $endDate->diff($start_Date);
        $days     = (int) $interval->format('%R%a');

        return $days * -1;
    }

    public function getStatusFormattedAttribute()
    {
        switch ($this->status) {
            case self::STATUS_RENTED:
                return 'Em andamento';
            case self::STATUS_LATE:
                return 'Em atraso';
            case self::STATUS_FINISHED;
                return 'Entregue';
            case self::STATUS_CANCELED:
                return 'Cancelado';
            default:
                return 'Status desconhecido';
        }
    }
}

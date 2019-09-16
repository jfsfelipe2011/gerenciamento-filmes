<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Rent
 * @package App
 */
class Rent extends Model
{
    /** @var string */
    const STATUS_RENTED   = 'rented';

    /** @var string */
    const STATUS_FINISHED = 'finished';

    /** @var string */
    const STATUS_LATE     = 'late';

    /** @var string */
    const STATUS_CANCELED = 'canceled';

    /** @var array */
    const VALID_STATUS = [
        self::STATUS_RENTED,
        self::STATUS_FINISHED,
        self::STATUS_LATE,
        self::STATUS_CANCELED
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'start_date', 'end_date', 'delivery_date', 'status', 'value', 'customer_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

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
    public function getStartDateFormattedAttribute()
    {
        return (new \DateTime($this->start_date))->format('d/m/Y');
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getEndDateFormattedAttribute()
    {
        return (new \DateTime($this->end_date))->format('d/m/Y');
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getDeliveryDateFormattedAttribute()
    {
        return is_null($this->delivery_date) ? '-' : (new \DateTime($this->delivery_date))
            ->format('d/m/Y');
    }

    /**
     * @return float|int
     * @throws \Exception
     */
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

    /**
     * @return float|int
     * @throws \Exception
     */
    public function daysOfRent()
    {
        $start_Date = new \DateTime($this->start_date);
        $endDate    = new \DateTime($this->end_date);

        $interval = $endDate->diff($start_Date);
        $days     = (int) $interval->format('%R%a');

        return $days * -1;
    }

    /**
     * @return string
     */
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

    /**
     * @return mixed
     * @throws \Exception
     */
    public static function getRentsExpireds()
    {
        $now = new \DateTime();

        return Rent::where('end_date', '<', $now->format('Y-m-d'))
            ->get();
    }
}

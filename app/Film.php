<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class Film
 * @package App
 */
class Film extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'image', 'duration', 'release_date', 'category_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function directors()
    {
        return $this->belongsToMany(Director::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function actors()
    {
        return $this->belongsToMany(Actor::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function stock()
    {
        return $this->hasOne(Stock::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function rents()
    {
        return $this->belongsToMany(Rent::class);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getReleaseDateFormattedAttribute()
    {
        return (new \DateTime($this->release_date))->format('d/m/Y');
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public static function getFilmsNotStock()
    {
        return DB::table('films')
            ->leftJoin('stocks', 'films.id', '=', 'stocks.film_id')
            ->whereNull('stocks.id')
            ->pluck('films.name', 'films.id');
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public static function getFilmsForRent()
    {
        return DB::table('films')
            ->Join('stocks', 'films.id', '=', 'stocks.film_id')
            ->where('stocks.quantity', '>', 0)
            ->pluck('films.name', 'films.id');
    }
}

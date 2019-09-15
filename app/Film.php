<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Film extends Model
{
    protected $fillable = [
        'name', 'description', 'image', 'duration', 'release_date', 'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function directors()
    {
        return $this->belongsToMany(Director::class);
    }

    public function actors()
    {
        return $this->belongsToMany(Actor::class);
    }

    public function stock()
    {
        return $this->hasOne(Stock::class);
    }

    public function rents()
    {
        return $this->belongsToMany(Rent::class);
    }

    public function getReleaseDateFormattedAttribute()
    {
        return (new \DateTime($this->release_date))->format('d/m/Y');
    }

    public static function getFilmsNotStock()
    {
        return DB::table('films')
            ->leftJoin('stocks', 'films.id', '=', 'stocks.film_id')
            ->whereNull('stocks.id')
            ->pluck('films.name', 'films.id');
    }
}

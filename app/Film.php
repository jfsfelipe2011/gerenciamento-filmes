<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    protected $fillable = [
        'name', 'description', 'image', 'duration', 'release_date', 'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

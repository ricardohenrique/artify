<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * Get all paintings in this category.
     */
    public function paintings()
    {
        return $this->hasMany(Painting::class);
//        return $this->hasMany(Painting::class)->where('is_draft', false);
    }

//    public function getRouteKeyName()
//    {
//        return 'slug';
//    }
}

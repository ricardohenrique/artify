<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Painting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'description',
        'price',
        'image_path',
        'category_id',
        'is_available',
        'is_draft',
    ];

    /**
     * The artist who owns the painting.
     */
    public function artist()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * The category this painting belongs to.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

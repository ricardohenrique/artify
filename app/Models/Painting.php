<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Painting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'is_draft',
        'title',
        'slug',
        'description',
        'price',
        'material',
        'year_created',
        'dimensions',
        'framed',
        'orientation',
        'category_id',
        'availability',
    ];

    /**
     * The artist who owns the painting.
     */
    public function user()
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

    public function images()
    {
        return $this->hasMany(PaintingImage::class);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    public function conversations()
    {
        return $this->hasMany(Conversation::class);
    }

    public function getRouteKeyName()
    {
        return 'id';
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}

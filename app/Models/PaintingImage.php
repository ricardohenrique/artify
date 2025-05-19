<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaintingImage extends Model
{
    protected $fillable = ['path', 'painting_id'];

    public function painting()
    {
        return $this->belongsTo(Painting::class);
    }
}

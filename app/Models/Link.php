<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Link extends Model
{
    use HasFactory;

    protected $fillable = ['slug', 'target_url', 'clicks'];

    public function clicks()
    {
        return $this->hasMany(LinkClick::class);
    }

}

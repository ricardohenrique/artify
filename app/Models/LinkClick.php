<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LinkClick extends Model
{
    use HasFactory;

    protected $fillable = ['ip_address', 'user_agent', 'referrer'];

    public function link()
    {
        return $this->belongsTo(Link::class);
    }
}

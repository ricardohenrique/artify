<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LinkClick extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip_address',
        'country',
        'city',
        'referrer',
        'browser',
        'platform',
        'device_type',
        'language',
    ];

    public function link()
    {
        return $this->belongsTo(Link::class);
    }
}

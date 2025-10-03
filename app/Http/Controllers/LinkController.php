<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;
// use GeoIP;

class LinkController extends Controller
{
    public function redirect($slug)
    {
        $link = Link::where('slug', $slug)->firstOrFail();

        $link->increment('clicks');

        // $location = geoip('84.192.12.34');
        $location = geoip()->getLocation('84.192.12.34', false); 
        // $location = geoip();
        dd($location);

        $location->ip;        // "84.192.12.34"
        $location->country;   // "Germany"
        $location->city;      // "Berlin"
        $location->iso_code;  // "DE"
        $location->state;     // "BE"
        $location->lat;       // 52.5244
        $location->lon;       // 13.4105


        $link->clicks()->create([
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'referrer' => request()->headers->get('referer'),
        ]);

        return redirect()->away($link->target_url);
    }
}

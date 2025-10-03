<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;
use Jenssegers\Agent\Agent;

class LinkController extends Controller
{
    public function redirect($slug)
    {
        $link = Link::where('slug', $slug)->firstOrFail();

        $link->increment('clicks');

        $location = geoip(request()->ip());
        $agent = new Agent();
        // dd($location, $agent);

        $link->clicks()->create([
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'referrer' => request()->headers->get('referer'),
            'country' => $location->country,
            'city' => $location->city,
            'browser' => $agent->browser(),
            'platform' => $agent->platform(),
            'device_type' => $agent->device(),
            'language' => request()->header('Accept-Language'),
        ]);

        return redirect()->away($link->target_url);
    }
}

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

        $ip = request()->ip();
        $agent = new Agent();
        $geo = null;

        try {
            $geo = geoip()->getLocation($ip, false);
        } catch (\Exception $e) {
            $geo = null;
        }

        $clickData = [
            'ip_address'  => $ip,
            'referrer'    => request()->headers->get('referer'),
            'browser'     => $agent->browser(),
            'platform'    => $agent->platform(),
            'device_type' => $agent->device(),
            'language'    => request()->header('Accept-Language'),
        ];

        if ($geo && $geo->country) {
            $clickData['country'] = $geo->country;
        }

        if ($geo && $geo->city) {
            $clickData['city'] = $geo->city;
        }

        $link->clicks()->create($clickData);

        return redirect()->away($link->target_url);
    }
}

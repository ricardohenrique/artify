<?php

declare(strict_types=1);

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class StaticPageController extends Controller
{
    public function aboutUs(): Response
    {
        return response()->view('about-us', [], 200);
    }

    public function privacyPolicy(): Response
    {
        return response()->view('privacy-policy', [], 200);
    }

    public function termsConditions(): Response
    {
        return response()->view('terms-conditions', [], 200);
    }

    public function faq(): Response
    {
        return response()->view('faq', [], 200);
    }

    public function howArtifyWorks(): Response
    {
        return response()->view('how-artify-works', [], 200);
    }
}

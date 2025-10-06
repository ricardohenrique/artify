<?php

namespace App\Http\Controllers;

class FAQController extends Controller
{
    public function index()
    {
        return response()->view('faq', [], 200);
    }
}

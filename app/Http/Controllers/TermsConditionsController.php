<?php

namespace App\Http\Controllers;

class TermsConditionsController extends Controller
{
    public function index()
    {
        return response()->view('terms-conditions', [], 200);
    }
}

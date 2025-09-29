<?php

namespace App\Http\Controllers;

class PrivacyPolicyController extends Controller
{
    public function index()
    {
        return response()->view('privacy-policy', [], 200);
    }
}

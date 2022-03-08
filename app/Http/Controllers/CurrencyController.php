<?php

namespace App\Http\Controllers;

use App\Models\Currency;

class CurrencyController extends Controller
{
    public function index()
    {
        return Currency::all();

    }

    public function show($code)
    {
        return Currency::where('code', $code)->first();
    }
}

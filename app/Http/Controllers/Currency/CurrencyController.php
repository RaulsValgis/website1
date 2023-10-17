<?php

namespace App\Http\Controllers\Currency;


use App\Http\Controllers\Controller;

class CurrencyController extends Controller
{

    public function index()
    {
        return view('currency.index');
    }



}
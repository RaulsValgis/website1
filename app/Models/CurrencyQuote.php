<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CurrencyQuote extends Model
{
    use HasFactory;

    protected $table = 'currency_quotes';

    protected $fillable = [
        'currency_pair',
        'price',
    ];
}
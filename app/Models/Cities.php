<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Countries;

class Cities extends Model
{
    use HasFactory;

    protected $table = 'cities';

    protected $fillable = [
        'country_id',
        'city',
        'population',
    ];

    public $timestamps = true;

    public function countries()
    {
        return $this->belongsTo(Countries::class, 'country_id');
    }
}
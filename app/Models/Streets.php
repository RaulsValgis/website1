<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Streets extends Model
{
    protected $table = 'streets';

    protected $fillable = [
        'name', 
        'city_id', 
        'country_id'
    ];

    public $timestamps = true;

    public function cities()
    {
        return $this->belongsTo(Cities::class, 'city_id');
    }


    public function countries()
    {
        return $this->belongsTo(Countries::class, 'country_id');
    }
}
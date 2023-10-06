<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
    protected $fillable = ['name'];

    // Relationship with cities
    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
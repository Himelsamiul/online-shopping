<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Define the relationship: A unit can have many products
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}

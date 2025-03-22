<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Define the relationship: A product belongs to a category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Define the relationship: A product belongs to a unit
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;

    // Fields that can be mass-assigned
    protected $fillable = ['name'];
public function products()
    {
        return $this->hasMany(\App\Models\Product::class, 'size_id'); // make sure size_id is the foreign key
    }

}
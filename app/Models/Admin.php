<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    // If you're using a custom table name
    protected $table = 'admins'; // Make sure this matches your DB table name

    // If you're using a different primary key
    // protected $primaryKey = 'id'; 

    // Add fillable fields to protect from mass-assignment vulnerabilities
    protected $fillable = ['name', 'email', 'password'];

    // You may want to hash the password before saving
    protected static function boot()
    {
        parent::boot();
        static::saving(function ($admin) {
            if ($admin->isDirty('password')) {
                $admin->password = bcrypt($admin->password);
            }
        });
    }
}


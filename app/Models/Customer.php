<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // Import Authenticatable
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable; // Add Notifiable for notifications

class Customer extends Authenticatable // Extend from Authenticatable class
{
    use HasFactory, Notifiable; // Include Notifiable to send notifications

    protected $fillable = [
        'name', 'email', 'password', 'phoneno', 'address', 'image',
    ];

    protected $hidden = [
        'password', // Hide password in JSON responses
    ];

    protected $casts = [
        'email_verified_at' => 'datetime', // Optional: Cast email_verified_at to datetime if using email verification
    ];

    
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}

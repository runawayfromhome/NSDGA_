<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'accounts';

    protected $fillable = [
        'user',
        'full_name', 
        'email',        
        'phone_number',   
        'password',
        'role', 
        'is_locked',          
        'otp_code',
        'otp_expires_at',
    ];

    // Database Security
    protected $casts = [
        'full_name' => 'encrypted',
        'phone_number' => 'encrypted',
        'is_locked' => 'boolean', 
        'otp_expires_at' => 'datetime',
    ];
    

    protected $hidden = [
        'password',
        'remember_token',
        'otp_code', 
    ];

    public function username()
    {
        return 'user';
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $fillable = ['user_id', 'action', 'target', 'ip_address'];

    // Link each log to the User who performed the action
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
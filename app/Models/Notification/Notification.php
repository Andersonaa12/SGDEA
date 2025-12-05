<?php

namespace App\Models\Notification;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

class Notification extends Model implements AuditableContract
{
    use HasFactory, Auditable;

    protected $table = 'notifications';

    protected $fillable = [
        'user_id', 'type', 'message', 'priority', 'link', 'read',
        'created_by', 'updated_by'
    ];

    // Relaciones
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(\App\Models\User::class, 'updated_by');
    }
}
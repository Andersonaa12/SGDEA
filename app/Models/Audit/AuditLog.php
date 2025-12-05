<?php

namespace App\Models\Audit;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;

    protected $table = 'audit_logs';

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    protected $fillable = [
        'auditable_id', 'auditable_type', 'user_id', 'event', 'old_values',
        'new_values', 'ip_address', 'user_agent'
    ];

    // Relaciones
    public function auditable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
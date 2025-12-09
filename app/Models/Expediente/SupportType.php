<?php

namespace App\Models\Expediente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

class SupportType extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'support_types';

    protected $fillable = [
        'code',
        'name',
        'description',
        'is_physical',
        'is_electronic',
        'active',
    ];

    protected $casts = [
        'is_physical' => 'boolean',
        'is_electronic' => 'boolean',
        'active' => 'boolean',
        'deleted_at' => 'datetime',
    ];

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function getIsHybridAttribute(): bool
    {
        return $this->is_physical && $this->is_electronic;
    }
    public function getShortDescriptionAttribute(): string
    {
        if ($this->code === 'FIS') return 'Solo físico';
        if ($this->code === 'ELE') return 'Solo electrónico';
        if ($this->code === 'AMB') return 'Físico + Electrónico';
        return $this->name;
    }
}
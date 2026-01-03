<?php

namespace App\Models\Trd;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;
use App\Traits\TracksCreatorUpdater;

class Trd extends Model implements AuditableContract
{
    use HasFactory, SoftDeletes, Auditable, TracksCreatorUpdater;

    protected $table = 'trds';

    protected $fillable = [
        'version', 'approval_date', 'valid_from', 'valid_to', 'approval_file', 'active',
        'created_by', 'updated_by'
    ];

    // Relaciones
    public function series()
    {
        return $this->hasMany(Serie::class, 'trd_id');
    }

    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(\App\Models\User::class, 'updated_by');
    }

    // Funciones
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

}
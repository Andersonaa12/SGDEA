<?php

namespace App\Models\Configuration;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;
use App\Traits\TracksCreatorUpdater;

class Configuration extends Model implements AuditableContract
{
    use HasFactory, Auditable, TracksCreatorUpdater;

    protected $table = 'configurations';

    protected $fillable = [
        'key', 'value', 'created_by', 'updated_by'
    ];

    // Relaciones
    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(\App\Models\User::class, 'updated_by');
    }
}
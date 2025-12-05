<?php

namespace App\Models\Trd;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

class Serie extends Model implements AuditableContract
{
    use HasFactory, SoftDeletes, Auditable;

    protected $table = 'series';

    protected $fillable = [
        'trd_id', 'code', 'name', 'description', 'retention_management_years',
        'retention_central_years', 'final_disposition', 'disposition_procedure',
        'created_by', 'updated_by'
    ];

    // Relaciones
    public function trd()
    {
        return $this->belongsTo(Trd::class);
    }

    public function subseries()
    {
        return $this->hasMany(Subserie::class, 'serie_id');
    }

    public function expedientes()
    {
        return $this->hasMany(\App\Models\Expediente\Expediente::class, 'serie_id');
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
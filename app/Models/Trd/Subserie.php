<?php

namespace App\Models\Trd;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

class Subserie extends Model implements AuditableContract
{
    use HasFactory, SoftDeletes, Auditable;

    protected $table = 'subseries';

    protected $fillable = [
        'serie_id', 'code', 'name', 'description',
        'created_by', 'updated_by'
    ];

    // Relaciones
    public function serie()
    {
        return $this->belongsTo(Serie::class);
    }

    public function documentTypes()
    {
        return $this->hasMany(DocumentType::class, 'subserie_id');
    }

    public function expedientes()
    {
        return $this->hasMany(\App\Models\Expediente\Expediente::class, 'subserie_id');
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
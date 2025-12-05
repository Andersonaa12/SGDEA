<?php

namespace App\Models\Expediente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

class Expediente extends Model implements AuditableContract
{
    use HasFactory, SoftDeletes, Auditable;

    protected $table = 'expedientes';

    protected $casts = [
        'metadata' => 'array',
    ];

    protected $fillable = [
        'number', 'subject', 'detail', 'parent_id', 'structure_id', 'section_id',
        'subsection_id', 'serie_id', 'subserie_id', 'phase', 'physical', 'opening_date',
        'closing_date', 'version', 'status', 'metadata', 'created_by', 'updated_by'
    ];

    // Relaciones
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function structure()
    {
        return $this->belongsTo(\App\Models\Structure\OrganizationalStructure::class);
    }

    public function section()
    {
        return $this->belongsTo(\App\Models\Structure\Section::class);
    }

    public function subsection()
    {
        return $this->belongsTo(\App\Models\Structure\Subsection::class);
    }

    public function serie()
    {
        return $this->belongsTo(\App\Models\Trd\Serie::class);
    }

    public function subserie()
    {
        return $this->belongsTo(\App\Models\Trd\Subserie::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'expediente_id');
    }

    public function histories()
    {
        return $this->hasMany(ExpedienteHistory::class, 'expediente_id');
    }

    public function loans()
    {
        return $this->hasMany(ExpedienteLoan::class, 'expediente_id');
    }

    public function transfers()
    {
        return $this->hasMany(\App\Models\Transfer\Transfer::class, 'expediente_id');
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
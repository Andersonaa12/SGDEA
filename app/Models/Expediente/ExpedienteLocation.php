<?php

namespace App\Models\Expediente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class ExpedienteLocation extends Model implements Auditable
{
    use HasFactory, SoftDeletes, AuditableTrait;

    protected $table = 'expediente_locations';

    protected $fillable = [
        'expediente_id',
        'box',
        'folder',
        'type',
        'volume_number',
        'folios_count',
        'additional_details',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'folios_count' => 'integer',
    ];

    // === Relaciones ===
    public function expediente()
    {
        return $this->belongsTo(Expediente::class);
    }

    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(\App\Models\User::class, 'updated_by');
    }

    // === Accessors ===

    public function getFullLocationAttribute(): string
    {
        $parts = [];

        if ($this->box) $parts[] = "Caja: {$this->box}";
        if ($this->folder) $parts[] = "Carpeta: {$this->folder}";
        if ($this->type) $parts[] = $this->getTypeLabelAttribute();
        if ($this->volume_number) $parts[] = "No. {$this->volume_number}";
        if ($this->folios_count) $parts[] = "{$this->folios_count} folios";

        return $parts ? implode(' | ', $parts) : 'No physical location assigned';
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'Tomo'   => 'Tomo',
            'Legajo' => 'Legajo',
            'Libro'  => 'Libro',
            'Otros'  => 'Otros',
            default  => $this->type ?? 'Desconocido',
        };
    }
}
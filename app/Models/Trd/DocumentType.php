<?php

namespace App\Models\Trd;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

class DocumentType extends Model implements AuditableContract
{
    use HasFactory, SoftDeletes, Auditable;

    protected $table = 'document_types';

    protected $casts = [
        'required_metadata' => 'array',
    ];

    protected $fillable = [
        'subserie_id', 'code', 'name', 'required_metadata', 'analog', 'requires_signature',
        'allowed_formats', 'created_by', 'updated_by'
    ];

    // Relaciones
    public function subserie()
    {
        return $this->belongsTo(Subserie::class);
    }

    public function documents()
    {
        return $this->hasMany(\App\Models\Expediente\Document::class, 'document_type_id');
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
    public static function generateCode(Subserie $subserie)
    {
        $lastNumber = self::withTrashed()
            ->where('subserie_id', $subserie->id)
            ->max(\Illuminate\Support\Facades\DB::raw("CAST(SUBSTRING_INDEX(code, '.', -1) AS UNSIGNED)"));

        $next = ($lastNumber ?? 0) + 1;

        return $subserie->code . '.' . str_pad($next, 3, '0', STR_PAD_LEFT);
    }
}
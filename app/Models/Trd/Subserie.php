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

    // Funciones
    public static function generateCode(Serie $serie)
    {
        $lastNumber = self::withTrashed()
            ->where('serie_id', $serie->id)
            ->max(\Illuminate\Support\Facades\DB::raw("CAST(SUBSTRING_INDEX(code, '.', -1) AS UNSIGNED)"));

        $next = ($lastNumber ?? 0) + 1;

        return $serie->code . '.' . str_pad($next, 3, '0', STR_PAD_LEFT);
    }
}
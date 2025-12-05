<?php

namespace App\Models\Structure;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

class Subsection extends Model implements AuditableContract
{
    use HasFactory, SoftDeletes, Auditable;

    protected $table = 'subsections';

    protected $fillable = [
        'section_id', 'code', 'name', 'physical_location',
        'created_by', 'updated_by'
    ];

    // Relaciones
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function users()
    {
        return $this->belongsToMany(\App\Models\User::class, 'subsection_user')
            ->withPivot('role_in_subsection')
            ->withTimestamps();
    }

    public function expedientes()
    {
        return $this->hasMany(\App\Models\Expediente\Expediente::class, 'subsection_id');
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
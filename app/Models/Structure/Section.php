<?php

namespace App\Models\Structure;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

class Section extends Model implements AuditableContract
{
    use HasFactory, SoftDeletes, Auditable;

    protected $table = 'sections';

    protected $fillable = [
        'structure_id', 'code', 'name', 'physical_location', 'responsible_user_id',
        'created_by', 'updated_by'
    ];

    // Relaciones
    public function structure()
    {
        return $this->belongsTo(OrganizationalStructure::class);
    }

    public function responsible()
    {
        return $this->belongsTo(\App\Models\User::class, 'responsible_user_id');
    }

    public function subsections()
    {
        return $this->hasMany(Subsection::class, 'section_id');
    }

    public function users()
    {
        return $this->belongsToMany(\App\Models\User::class, 'section_user')
            ->withPivot('role_in_section')
            ->withTimestamps();
    }

    public function expedientes()
    {
        return $this->hasMany(\App\Models\Expediente\Expediente::class, 'section_id');
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
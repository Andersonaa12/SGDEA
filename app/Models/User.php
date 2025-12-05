<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements AuditableContract
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, Auditable, HasRoles;

    protected $fillable = [
        'name', 'identification', 'email', 'phone', 'password', 'section_id',
        'position', 'active', 'created_by', 'updated_by'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relaciones
    public function section()
    {
        return $this->belongsTo(\App\Models\Structure\Section::class);
    }

    public function sections()
    {
        return $this->belongsToMany(\App\Models\Structure\Section::class, 'section_user')
            ->withPivot('role_in_section')
            ->withTimestamps();
    }

    public function subsections()
    {
        return $this->belongsToMany(\App\Models\Structure\Subsection::class, 'subsection_user')
            ->withPivot('role_in_subsection')
            ->withTimestamps();
    }

    public function expedientesCreated()
    {
        return $this->hasMany(\App\Models\Expediente\Expediente::class, 'created_by');
    }

    public function documentsUploaded()
    {
        return $this->hasMany(\App\Models\Expediente\Document::class, 'uploaded_by');
    }

    public function loans()
    {
        return $this->hasMany(\App\Models\Expediente\ExpedienteLoan::class, 'user_id');
    }

    public function transfersApproved()
    {
        return $this->hasMany(\App\Models\Transfer\Transfer::class, 'approved_by');
    }

    public function searchFavorites()
    {
        return $this->hasMany(\App\Models\Search\SearchFavorite::class, 'user_id');
    }

    public function notifications()
    {
        return $this->hasMany(\App\Models\Notification\Notification::class, 'user_id');
    }

    public function auditLogs()
    {
        return $this->hasMany(\App\Models\Audit\AuditLog::class, 'user_id');
    }

    public function creator()
    {
        return $this->belongsTo(self::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(self::class, 'updated_by');
    }
}
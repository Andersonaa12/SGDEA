<?php

namespace App\Models\Expediente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Auth;
use App\Traits\TracksCreatorUpdater;

class Expediente extends Model implements AuditableContract
{
    use HasFactory, SoftDeletes, Auditable, TracksCreatorUpdater;

    protected $table = 'expedientes';

    protected $casts = [
        'metadata' => 'array',
    ];

    protected $fillable = [
        'number', 'name', 'subject', 'detail', 'parent_id', 'structure_id', 'section_id',
        'subsection_id', 'serie_id', 'subserie_id', 'opening_date',
        'closing_date', 'version', 'status','created_by', 'updated_by','support_type_id',
        'phase_id',
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

    public function supportType()
    {
        return $this->belongsTo(SupportType::class, 'support_type_id');
    }

    public function phase()
    {
        return $this->belongsTo(Phase::class, 'phase_id');
    }

    public function responsible()
    {
        return $this->belongsTo(\App\Models\User::class, 'responsible_id');
    }

    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(\App\Models\User::class, 'updated_by');
    }

    public function currentLocation()
    {
        return $this->hasOne(ExpedienteLocation::class)->latestOfMany();
    }

    public function locations()
    {
        return $this->hasMany(ExpedienteLocation::class)->orderByDesc('created_at');
    }

    public function latestLocation()
    {
        return $this->hasOne(ExpedienteLocation::class)->orderByDesc('created_at');
    }
    public function metadata()
    {
        return $this->hasMany(ExpedienteMetadata::class);
    }
    public function metadataAll()
    {
        return $this->hasMany(ExpedienteMetadata::class);
    }

    public function metadataValues()
    {
        return $this->belongsToMany(MetadataType::class, 'expediente_metadata')
                    ->withPivot('value')
                    ->withTimestamps();
    }

    // Scopes 
    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    public function scopeClosed($query)
    {
        return $query->where('status', 'closed');
    }

    public function scopeArchived($query)
    {
        return $query->where('status', 'archived');
    }

    public function scopeActivePhase($query)
    {
        return $query->whereHas('phase', fn($q) => $q->where('active', true));
    }

    // Accessors

    public function getIsClosedAttribute(): bool
    {
        return $this->status === 'closed' || $this->status === 'archived';
    }

    public function getIsPhysicalAttribute(): bool
    {
        return $this->supportType?->is_physical ?? false;
    }

    public function getIsElectronicAttribute(): bool
    {
        return $this->supportType?->is_electronic ?? false;
    }

    public function getIsHybridAttribute(): bool
    {
        return $this->supportType?->is_physical && $this->supportType?->is_electronic;
    }

    public function getFullNumberAttribute(): string
    {
        return $this->number;
    }
    private function generateNumber(): string
    {
        $year = Date::now()->year;
        $count = static::whereYear('created_at', $year)->count() + 1;
        $paddedId = str_pad($count, 5, '0', STR_PAD_LEFT);

        return "EXP-{$year}-{$paddedId}";
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->number = $model->generateNumber();
        });
    }
}
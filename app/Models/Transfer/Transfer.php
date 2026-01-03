<?php

namespace App\Models\Transfer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;
use App\Traits\TracksCreatorUpdater;

class Transfer extends Model implements AuditableContract
{
    use HasFactory, SoftDeletes, Auditable, TracksCreatorUpdater;

    protected $table = 'transfers';

    protected $casts = [
        'conservation_data' => 'array',
    ];

    protected $fillable = [
        'expediente_id', 'type', 'transfer_date', 'inventory_file', 'physical_location',
        'conservation_data', 'notes', 'approved_by', 'created_by', 'updated_by'
    ];

    // Relaciones
    public function expediente()
    {
        return $this->belongsTo(\App\Models\Expediente\Expediente::class);
    }

    public function approver()
    {
        return $this->belongsTo(\App\Models\User::class, 'approved_by');
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
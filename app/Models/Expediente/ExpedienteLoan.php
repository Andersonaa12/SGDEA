<?php

namespace App\Models\Expediente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;
use App\Traits\TracksCreatorUpdater;

class ExpedienteLoan extends Model implements AuditableContract
{
    use HasFactory, SoftDeletes, Auditable, TracksCreatorUpdater;

    protected $table = 'expediente_loans';

    protected $fillable = [
        'expediente_id', 'user_id', 'loan_date', 'return_date', 'reason', 'status', 'notes',
        'created_by', 'updated_by'
    ];

    // Relaciones
    public function expediente()
    {
        return $this->belongsTo(Expediente::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
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
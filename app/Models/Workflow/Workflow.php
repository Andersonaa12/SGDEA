<?php

namespace App\Models\Workflow;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;
use App\Traits\TracksCreatorUpdater;

class Workflow extends Model implements AuditableContract
{
    use HasFactory, SoftDeletes, Auditable, TracksCreatorUpdater;

    protected $table = 'workflows';

    protected $fillable = [
        'name', 'description', 'active', 'created_by', 'updated_by'
    ];

    // Relaciones
    public function steps()
    {
        return $this->hasMany(WorkflowStep::class, 'workflow_id');
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
<?php

namespace App\Models\Expediente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Phase extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'phases';
    public const CODE_MGMT = 'MGMT';
    public const CODE_CENT = 'CENT';
    public const CODE_HIST = 'HIST';
    
    protected $fillable = [
        'code',
        'name',
        'description',
        'order',
        'preservation_years',
        'active',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
        'active' => 'boolean',
        'preservation_years' => 'integer',
        'order' => 'integer',
        'deleted_at' => 'datetime',
    ];

    
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('name');
    }
}
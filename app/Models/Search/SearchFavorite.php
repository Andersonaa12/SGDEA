<?php

namespace App\Models\Search;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;
use App\Traits\TracksCreatorUpdater;

class SearchFavorite extends Model implements AuditableContract
{
    use HasFactory, Auditable, TracksCreatorUpdater;

    protected $table = 'search_favorites';

    protected $casts = [
        'filters' => 'array',
    ];

    protected $fillable = [
        'user_id', 'name', 'filters', 'active', 'created_by', 'updated_by'
    ];

    // Relaciones
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
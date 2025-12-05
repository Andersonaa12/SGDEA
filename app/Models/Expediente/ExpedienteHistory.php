<?php

namespace App\Models\Expediente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpedienteHistory extends Model
{
    use HasFactory;

    protected $table = 'expediente_histories';

    protected $casts = [
        'changes' => 'array',
    ];

    protected $fillable = [
        'expediente_id', 'version', 'changes', 'event', 'user_id'
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
}
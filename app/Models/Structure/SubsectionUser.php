<?php

namespace App\Models\Structure;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubsectionUser extends Model
{
    use HasFactory;

    protected $table = 'subsection_user';

    protected $fillable = ['subsection_id', 'user_id', 'role_in_subsection'];

    // Relaciones
    public function subsection()
    {
        return $this->belongsTo(Subsection::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
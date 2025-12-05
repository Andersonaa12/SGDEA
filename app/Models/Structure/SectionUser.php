<?php

namespace App\Models\Structure;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionUser extends Model
{
    use HasFactory;

    protected $table = 'section_user';

    protected $fillable = ['section_id', 'user_id', 'role_in_section'];

    // Relaciones
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
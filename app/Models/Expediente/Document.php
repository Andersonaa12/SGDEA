<?php

namespace App\Models\Expediente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

class Document extends Model implements AuditableContract
{
    use HasFactory, SoftDeletes, Auditable;

    protected $table = 'documents';

    protected $casts = [
        'metadata' => 'array',
    ];

    protected $fillable = [
        'expediente_id', 'document_type_id', 'file_path', 'original_name', 'mime_type',
        'converted_from', 'size', 'document_date', 'folio', 'analog', 'physical_location',
        'ocr_applied', 'ocr_text', 'signed', 'signature_provider', 'metadata',
        'uploaded_by', 'updated_by'
    ];

    // Relaciones
    public function expediente()
    {
        return $this->belongsTo(Expediente::class);
    }

    public function documentType()
    {
        return $this->belongsTo(\App\Models\Trd\DocumentType::class);
    }

    public function uploader()
    {
        return $this->belongsTo(\App\Models\User::class, 'uploaded_by');
    }

    public function updater()
    {
        return $this->belongsTo(\App\Models\User::class, 'updated_by');
    }
}
<?php

namespace App\Models\Expediente;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ExpedienteMetadata extends Pivot
{
    protected $table = 'expediente_metadata';

    protected $fillable = ['expediente_id', 'metadata_type_id', 'value'];

    public function metadataType()
    {
        return $this->belongsTo(MetadataType::class);
    }
}
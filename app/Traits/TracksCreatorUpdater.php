<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait TracksCreatorUpdater
{
    protected static function bootTracksCreatorUpdater()
    {
        static::creating(function (Model $model) {
            $userId = Auth::id();
            if ($userId) {
                $model->created_by = $userId;
                $model->updated_by = $userId;
            }
        });
        static::updating(function (Model $model) {
            $userId = Auth::id();
            if ($userId) {
                $model->updated_by = $userId;
            }
        });
    }
}
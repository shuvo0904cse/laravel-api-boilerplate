<?php

namespace App\Traits;

use Illuminate\Support\Facades\Schema;

trait CreatedUpdatedBy
{
    protected static function bootCreatedUpdatedBy()
    {
          // updating created_by and updated_by when model is created
          static::creating(function ($model) {  
              if (!$model->isDirty('created_by') && Schema::hasColumn($model->getTable(), 'created_by')) {
                  $model->created_by = auth()->user() ? auth()->user()->id : null;
              }

              if (!$model->isDirty('updated_by') && Schema::hasColumn($model->getTable(), 'updated_by')) {
                  $model->updated_by = auth()->user() ? auth()->user()->id : null;
              }
          });

          // updating updated_by when model is updated
          static::updating(function ($model) {
              if (!$model->isDirty('updated_by') && Schema::hasColumn($model->getTable(), 'updated_by')) {
                  $model->updated_by = auth()->user() ? auth()->user()->id : null;
              }
          });
    }
}

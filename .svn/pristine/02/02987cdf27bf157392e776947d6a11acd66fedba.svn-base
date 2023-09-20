<?php

namespace App\Traits;

use Gate;
use DB;

trait AutoUpdateUserColumns {

  protected static function boot() {

    parent::boot();

    static::creating(function($model) {
      if (!auth()->guest() && auth('web')->user()) {
        $model->created_by = auth('web')->user()->id;
      }
//      if (!auth()->guest() && array_key_exists('std_user_id', get_object_vars($model)) && auth('students')->user()) {
//        $model->std_user_id = auth('students')->user()->id;
//      }
//      if (array_key_exists('update_centre_id', get_object_vars($model)) == FALSE || (array_key_exists('update_centre_id', get_object_vars($model)) && $model->update_centre_id == true)) {
//        if (!auth()->guest()) {
//          $model->centre_id = auth()->user()->centre_id;
//        }
//      }
      if (method_exists($model, 'saveAttributes')) {
        $model->saveAttributes();
      }
    });

    static::updating(function($model) {
      if (!auth()->guest() && auth('web')->user()) {
        $model->updated_by = auth('web')->user()->id;
      }
    });
  }

//  public function scopeCentreId($q, $centre_id = 0) {
//    if ($centre_id == 0 || ($centre_id != auth()->user()->centre_id && Gate::denies('all-centres-access') )) {
//      $centre_id = auth()->user()->centre_id;
//    }
//
//    return $q->where($this->getTable() . '.centre_id', '=', $centre_id);
//  }

  public function user_created() {
    return $this->belongsTo(\App\User::class, 'created_by', 'id');
  }

  public function user_modified() {
    return $this->belongsTo(\App\User::class, 'updated_by', 'id');
  }

}

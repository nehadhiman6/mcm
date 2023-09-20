<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits;

class Attachment extends Model {

  use Traits\ModelUtilities,
      Traits\AutoUpdateUserColumns;

  //
  protected $table = 'attachments';
  protected $fillable = ['admission_id', 'file_type', 'file_ext'];
  protected $connection = 'yearly_db';

  public function student() {
    return $this->belongsTo('App\AdmissionForm', 'admission_id', 'id');
  }

}

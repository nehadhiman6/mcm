<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits;

class SubjectCharge extends Model {

  use Traits\ModelUtilities,
      Traits\AutoUpdateUserColumns;

  protected $table = 'subject_charges';
  protected $fillable = ['installment_id', 'course_id', 'subject_id', 'pract_fee', 'pract_exam_fee', 'hon_fee', 'hon_exam_fee',
    'pract_id', 'hon_id', 'exam_id'];
  protected $connection = 'yearly_db';

  public function installment() {
    return $this->belongsTo(Installment::class, 'installment_id', 'id');
  }

  public function course() {
    return $this->belongsTo(Course::class, 'course_id', 'id');
  }

  public function subject() {
    return $this->belongsTo(Subject::class, 'subject_id', 'id');
  }

}

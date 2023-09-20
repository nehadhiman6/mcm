<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelUtilities;

class AcademicDetail extends Model {

  use Traits\ModelUtilities,
      Traits\AutoUpdateUserColumns;

  //
  protected $table = 'academic_detail';
  protected $numbers = [
    'board_id' => 'integer',
    'year' => 'integer',
    'marks' => 'integer',
    'marks_per' => 'integer',
  ];
  protected $fillable = ['admission_id', 'last_exam', 'exam', 'total_marks', 'marks_obtained', 'other_exam', 'institute', 'board_id', 'other_board', 'rollno', 'year', 'result', 'marks', 'marks_per', 'subjects','division','reappear_subjects','inst_state_id','cgpa'];
  protected $connection = 'yearly_db';

  public function student() {
    return $this->belongsTo(AdmissionForm::class, 'admission_id', 'id');
  }

  public function setYearAttribute($year) {
    $this->attributes['year'] = empty($year) ? 0 : $year;
  }

  public function setMarksAttribute($marks) {
    $this->attributes['marks'] = empty($marks) ? 0 : $marks;
  }

  public function setMarksPerAttribute($marks_per) {
    $this->attributes['marks_per'] = empty($marks_per) ? 0 : $marks_per;
  }

  public function board() {
    return $this->belongsTo(BoardUniv::class, 'board_id', 'id');
  }

  public function intitute_state() {
    return $this->belongsTo(State::class, 'inst_state_id', 'id');
  }

  public static function setLastExam($adm_id) {
    $details = static::where('admission_id',$adm_id)->get();
    $last_no = 0;
    $last_key = -1;
    foreach($details as $key => $val) {
      $val->last_exam = 'N';
      $val->save();
      $no = getAcademicExamNo($val->exam);
      if($no > $last_no) {
        $last_no = $no;
        $last_key = $key;
      }
    }
    if($last_key != -1) {
      $val = $details[$last_key];
      $val->last_exam = 'Y';
      $val->save();
    }
  }
}

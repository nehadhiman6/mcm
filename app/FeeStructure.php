<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits;
use Illuminate\Support\Facades\DB;

class FeeStructure extends Model {

  //
  use Traits\ModelUtilities,
      Traits\AutoUpdateUserColumns;

  protected $table = 'fee_structures';
  protected $fillable = ['course_id', 'std_type_id', 'installment_id', 'subhead_id', 'amount', 'optional', 'opt_default'];
  protected $connection = 'yearly_db';

  public function subhead() {
    return $this->belongsTo(SubFeeHead::class, 'subhead_id', 'id');
  }

  public static function getFeeInstallmet($student_det, $install_id) {
    $fee_str = static::join('sub_heads', 'sub_heads.id', '=', 'fee_structures.subhead_id')
      ->orderBy('sub_heads.feehead_id')->orderBy('sub_heads.name')
      ->whereCourseId($student_det->course_id)
      ->whereStdTypeId($student_det->std_type_id)->whereInstallmentId($install_id)
      ->with('subhead', 'subhead.feehead')
      ->select('fee_structures.*', 'sub_heads.feehead_id', DB::raw("fee_structures.opt_default as charge, fee_structures.subhead_id, fee_structures.amount as amt_rec, 0 as concession"))
      ->get();
//    return $fee_str;
//    $fee_str = $fee_str->groupBy('feehead_id');
    $fee_str = $fee_str->groupBy(function($item, $key) {
      return $item['subhead']['feehead']['name'];
    });
    return $fee_str;
  }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits;

class FeeBillDet extends Model {

  use Traits\ModelUtilities,
      Traits\AutoUpdateUserColumns;

  protected $table = 'fee_bill_dets';
//  protected $fillable = ['fee_bill_id', 'feehead_id', 'subhead_id', 'amount', 'concession'];
  protected $guarded = [];
  protected $connection = 'yearly_db';

  public function feehead() {
    return $this->belongsTo(FeeHead::class, 'feehead_id', 'id');
  }

  public function subhead() {
    return $this->belongsTo(SubFeeHead::class, 'subhead_id', 'id');
  }

}

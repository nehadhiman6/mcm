<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits;

class SubFeeHead extends Model {

  use Traits\ModelUtilities,
      Traits\AutoUpdateUserColumns;

  protected $table = 'sub_heads';
  protected $fillable = ['feehead_id', 'sno', 'name', 'group', 'refundable'];
  protected $connection = 'yearly_db';

  public function feehead() {
    return $this->belongsTo(FeeHead::class, 'feehead_id', 'id');
  }

  public static function getSubHeads($fund = 'C') {
    return \App\SubFeeHead::orderBy('name')
            ->whereIn('feehead_id', function($query) use($fund) {
              $query->from('fee_heads')
              ->where(function($q) use($fund) {
                $q->where('fund', $fund);
              })
              ->select('id');
            })
            ->with(['feehead.fund'])
            ->get();
  }

}

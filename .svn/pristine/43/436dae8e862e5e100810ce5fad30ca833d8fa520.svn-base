<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits;

class FeeHead extends Model {

  use Traits\ModelUtilities,
      Traits\AutoUpdateUserColumns;

  protected $table = 'fee_heads';
  protected $fillable = ['name', 'acc_id', 'optional', 'refundable', 'fund', 'fund_id','concession'];
  protected $connection = 'yearly_db';

  public function subHeads() {
    return $this->hasMany(SubFeeHead::class, 'feehead_id', 'id')->orderBy('name');
  }

  public function fund() {
    return $this->belongsTo(Fund::class, 'fund_id', 'id');
  }

  public static function getFeeHeads() {
    return \App\FeeHead::orderBy('name')->get()->map(function($fh, $key) {
        return ["feehead_id" => $fh['id']] + array_only($fh->attributesToArray(), ['feehead']);
      });
  }

}

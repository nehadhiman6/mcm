<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits;

class FeeRcptDet extends Model
{
    use Traits\ModelUtilities,
      Traits\AutoUpdateUserColumns;

    protected $table = 'fee_rcpt_dets';
    protected $guarded = [];
    //  protected $fillable = ['fee_rcpt_id','fee_bill_dets_id', 'feehead_id', 'subhead_id', 'amount', 'concession'];
    protected $connection = 'yearly_db';

    //  public function feehead() {
//    return $this->belongsTo(FeeHead::class, 'feehead_id', 'id');
    //  }

    public function subhead()
    {
        return $this->belongsTo(SubFeeHead::class, 'subhead_id', 'id');
    }

    public function feeHead()
    {
        return $this->belongsTo(FeeHead::class, 'feehead_id', 'id');
    }

    public function feebilldet()
    {
        return $this->belongsTo(FeeBillDet::class, 'fee_bill_dets_id', 'id');
    }
}

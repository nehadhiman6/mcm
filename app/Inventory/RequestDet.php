<?php

namespace App\Inventory;

use Illuminate\Database\Eloquent\Model;
use App\Traits;

class RequestDet extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;

    protected $table = 'request_dets';
    protected $fillable = ['item_id', 'req_qty','req_for','request_id'];
    protected $connection = 'mysql';
}

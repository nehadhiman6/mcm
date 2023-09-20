<?php

namespace App\Inventory;

use Illuminate\Database\Eloquent\Model;
use App\Traits;

class IssueDet extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;

    protected $table = 'issue_dets';
    protected $fillable = ['item_id', 'req_qty','req_for','issue_id','description'];
    protected $connection = 'mysql';
}

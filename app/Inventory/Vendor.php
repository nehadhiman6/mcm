<?php

namespace App\Inventory;

use Illuminate\Database\Eloquent\Model;
use App\Traits;

class Vendor extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;

    protected $table = 'vendors';
    protected $fillable = ['vendor_name', 'mobile','code', 'city_id','deals_in_type_goods', 'vendor_address','contact_no','contact_person'];
    protected $connection = 'mysql';
}

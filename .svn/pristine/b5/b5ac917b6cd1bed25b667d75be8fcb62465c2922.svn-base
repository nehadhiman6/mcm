<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits;

class StuCrtPass extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;
    protected $table = 'stu_crt_passes';
    protected $fillable =['req_date','stu_name','class','roll_no','session','issue_date','type','contact_no','email','rejected','remarks','add'];
    protected $connection = 'mysql';

    public function setReqDateAttribute($date)
    {
        $this->attributes['req_date'] = setDateAttribute($date); 
    }

    public function getReqDateAttribute($date)
    {
        return getDateAttribute($date);
    }

    public function setIssueDateAttribute($date)
    {
        $this->attributes['issue_date'] = setDateAttribute($date); 
    }

    public function getIssueDateAttribute($date)
    {
        return getDateAttribute($date);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits;

class AppSetting extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;
    protected $table = 'app_setting';
    protected $fillable =['key_name','key_value','description'];
    protected $connection = 'mysql';

    
}

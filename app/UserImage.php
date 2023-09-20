<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserImage extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;

protected $table = 'user_images';
protected $fillable = [
    'id','user_id','file_name','extension','mime_type'
];
protected $connection = 'mysql';
}

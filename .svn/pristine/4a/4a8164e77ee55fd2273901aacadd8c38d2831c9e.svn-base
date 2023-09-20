<?php

namespace App\Models\Resource;

use Illuminate\Database\Eloquent\Model;
use App\Traits;

class Attachment extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;
    protected $table = "uploads";
    protected $connection = 'yearly_db';
    protected $fillable = [
        'file_name',
        'file_ext',
        'mime_type'
    ];
}

<?php

namespace App\Models\Resource;

use Illuminate\Database\Eloquent\Model;
use App\Traits;

class Resource extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;
    protected $table = "resources";
    protected $connection = 'yearly_db';
    protected $fillable = [
        'resourceable_type',
        'resourceable_id',
        'attachment_id',
        'remarks',
        'doc_type',
        'doc_description'
    ];

    public function attachment(){
        return $this->belongsTo(Attachment::class,'attachment_id');
    }
}

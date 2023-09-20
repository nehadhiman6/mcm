<?php

namespace App\Models\ExamLocation;

use Illuminate\Database\Eloquent\Model;
use App\Traits;
use App\Location;

class ExamLocation extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;

    protected $connection = 'yearly_db';
    protected $table = 'exam_locations';
    protected $fillable = ['loc_id',
    'seating_capacity',
    'no_of_rows',
    'center'];

    public function exam_loc_dets(){
        return $this->hasMany(ExamLocationDetail::class,'exam_location_id','id')->orderBy('row_no');
    }

    public function location(){
        return $this->belongsTo(Location::class,'loc_id','id');
    }
}

<?php

namespace App\Models\ExamLocation;

use Illuminate\Database\Eloquent\Model;
use App\Traits;

class ExamLocationDetail extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;

    protected $connection = 'yearly_db';
    protected $table = 'exam_locations_dets';
    protected $fillable = ['exam_location_id','row_no',  'seats_in_row'];

}

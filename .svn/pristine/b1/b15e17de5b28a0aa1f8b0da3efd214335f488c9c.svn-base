<?php

namespace App\Models\Hostel;

use Illuminate\Database\Eloquent\Model;
use App\Traits;
use App\Student;

class HostelNightOut extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;

    protected $table = 'hostel_night_out';
    protected $connection = 'yearly_db';
    protected $fillable = ['roll_no',
    'destination_address',
    'departure_date',
    'departure_time',
    'expected_return_date',
    'actual_return_date',
    'return_status',
    'remarks'];

    public function student(){
        return $this->belongsTo(Student::class,'roll_no','roll_no');
    }

    public function setDepartureDateAttribute($date)
    {
        $this->attributes['departure_date'] = setDateAttribute($date);
    }

    public function getDepartureDateAttribute($date)
    {
        return getDateAttribute($date);
    }

    public function setExpectedReturnDateAttribute($date)
    {
        $this->attributes['expected_return_date'] = setDateAttribute($date);
    }

    public function getExpectedReturnDateAttribute($date)
    {
        return getDateAttribute($date);
    }

    public function setActualReturnDateAttribute($date)
    {
        $this->attributes['actual_return_date'] = setDateAttribute($date);
    }

    public function getActualReturnDateAttribute($date)
    {
        return getDateAttribute($date);
    }

    public function getDepartureTimeAttribute($date)
    {
        return getTimeAttribute($date);
    }
}


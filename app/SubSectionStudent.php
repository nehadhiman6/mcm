<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubSectionStudent extends Model
{
    //
    protected $table = 'sub_sec_students';
    protected $fillable = ['sub_sec_id', 'std_id'];
    protected $connection = 'yearly_db';

    public function subjectSection()
    {
        return $this->belongsTo(SubjectSection::class, 'sub_sec_id', 'id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'std_id', 'id');
    }
    
    // public function marks()
    // {
    //     return $this->belongsTo(StudentMarks::class, 'sub_sec_id', 'sub_sec_id')->where('std_id',$this->std_id);
    // }


    public static function getAttendance($sub_sec_id, $month)
    {
        return static::join('students', 'students.id', '=', 'sub_sec_dets.std_id')
            ->leftJoin('attendance', function ($q) use ($month) {
                $q->on('sub_sec_dets.sub_sec_id', '=', 'attendance.sub_sec_id')
                    ->where('attendance.monthno', '=', $month);
            })
            ->leftJoin('attendance_det', function ($q) {
                $q->on('attendance_det.attendance_id', '=', 'attendance.id')
                    ->on('sub_sec_dets.std_id', '=', 'attendance_det.std_id');
            })
            ->where('sub_sec_dets.sub_sec_id', '=', $sub_sec_id)
            ->select('sub_sec_dets.*', 'students.roll_no', 'students.name', 'students.father_name', DB::raw('ifnull(attendance_det.attended,0) as attended'))
            ->get();
    }
}

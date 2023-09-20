<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrvStudent extends Student
{
    protected $connection = "prv_year_db";

    public function getOldSubs()
    {
        return $this->join('student_subs', 'student_subs.student_id', '=', 'students.id')
            ->join(getSharedDb() . 'subjects', 'subjects.id', '=', 'student_subs.subject_id')
            ->where('students.id', '=', $this->id)
            ->get(['student_subs.subject_id', 'subjects.subject']);
    }

    public function getOldHonSub()
    {
        return $this->join('admission_entries', 'admission_entries.id', 'students.adm_entry_id')
            ->join(getSharedDb() . 'subjects', 'subjects.id', '=', 'admission_entries.honour_sub_id')
            // ->join('subject_charges', function ($q) {
            //     $q->on('admission_entries.honour_sub_id', '=', 'subject_charges.subject_id')
            //         ->on('students.course_id', '=', 'subject_charges.course_id');
            // })
            ->where('students.id', '=', $this->id)
            ->select('subjects.*')
            ->get();
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
}

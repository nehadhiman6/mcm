<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits;
use Carbon\Carbon;

class Course extends Model
{
    use
        Traits\ModelUtilities,
        Traits\AutoUpdateUserColumns;

    //
    protected $table = 'courses';
    protected $fillable = [
        'class_code', 'sno', 'course_id', 'course_name', 'semester', 'course_year', 'st_rollno',
        'end_rollno', 'status', 'min_optional', 'max_optional', 'sub_combination', 'sub_no', 'no_of_seats', 'adm_open', 'adm_close_date', 'honours_link', 'sf', 'parent_course_id'
    ];
    protected $connection = 'yearly_db';

    public function students()
    {
        return $this->hasMany(Student::class, 'course_id', 'id');
    }

    public function adm_forms()
    {
        return $this->hasMany(AdmissionForm::class, 'course_id', 'id');
    }

    public function subjects()
    {
        return $this->hasMany(CourseSubject::class, 'course_id', 'id');
    }

    public function electives()
    {
        return $this->hasMany(Elective::class, 'course_id', 'id');
    }

    public function electivegroups()
    {
        return $this->hasMany(ElectiveGroup::class, 'course_id', 'id');
    }

    public function subgroups()
    {
        return $this->hasMany(SubjectGroup::class, 'course_id', 'id');
    }

    public function getSubs($subtype)
    {
        $subs = [];
        foreach ($this->subjects as $value) {
            if ($value->sub_type == $subtype) {
                $subs[] = ['id' => $value->subject_id, 'subject' => data_get($value->subject, 'subject')];
            }
        }
        return $subs;
    }

    public function getSubGroups($subtype)
    {
        $subGrps = [];
        foreach ($this->subgroups as $subgrp) {
            if ($subgrp->type == $subtype) {
                $subs = [];
                foreach ($subgrp->subjects as $value) {
                    $subs[] = ['id' => $value->subject_id, 'subject' => $value->subject->subject];
                }
                $subGrps[] = ['id' => $subgrp->id, 'group_name' => $subgrp->group_name, 'selectedid' => 0, 'details' => $subs];
            }
        }
        return $subGrps;
    }

    public function getElectives()
    {
        return $this->electives()->orderBy('name')->with('electiveSubjects.subject', 'groups.details.subject')->get();
    }


    public function getHonours()
    {
        $subs = [];
        $this->subjects->load('subject');
        foreach ($this->subjects as $value) {
            $sub = '';
            if ($value->honours == 'Y') {
                $sub = $value;
                array_push($subs, $sub);
            }
        }
        return $subs;
    }

    public function getSubjectsForCharges()
    {
        $subjects = CourseSubject::join(getSharedDb() . 'subjects', 'subjects.id', '=', 'course_subject.subject_id')
            ->select('subjects.*')
            ->where('course_subject.course_id', '=', $this->id)
            ->where(function ($q) {
                $q->where('course_subject.practical', '=', 'Y')
                    ->orWhere('course_subject.honours', '=', 'Y');
            })
            ->orderBy('subjects.subject')
            // ->union(
            //     SubjectGroup::join('subject_group_det', 'subject_group.id', '=', 'subject_group_det.sub_group_id')
            //         ->join('subjects', 'subjects.id', '=', 'subject_group_det.subject_id')->select('subjects.*')->where('subject_group.course_id', '=', $course->id)->where('subject_group_det.practical', '=', 'Y')
            // )
            ->get();
        return $subjects;
    }

    public function getAllSubs()
    {
        $subs = [];
        foreach ($this->subjects as $value) {
            $subs[] = ['id' => $value->subject_id, 'subject' => $value->subject->subject];
        }
        foreach ($this->subgroups as $subgrp) {
            foreach ($subgrp->subjects as $value) {
                $subs[] = ['id' => $value->subject_id, 'subject' => $value->subject->subject];
            }
        }
        $final = array();

        foreach ($subs as $current) {
            if (!in_array($current, $final)) {
                $final[] = $current;
            }
        }
        return $final;
    }




    public function setAdmCloseDateAttribute($date)
    {
        $this->attributes['adm_close_date'] = setDateAttribute($date); //getDateFormat($this->adm_close_date, 'ymd');
    }

    public function getAdmCloseDateAttribute($date)
    {
        return getDateAttribute($date);
    }

    public function getSubjectStatus($sub_id)
    {
        $course_subject = $this->subjects()->whereSubjectId($sub_id)->get();
        // return $course_subject;
        if ($course_subject->count() > 0) {
            return $course_subject->sub_type;
        }

        return $this->subgroups()
            ->join('subject_group_det', 'subject_group_det.sub_group_id', '=', 'subject_group.id')
            ->where('subject_group_det.subject_id', '=', $sub_id)
            ->count() > 0 ? 'O' : 'NA';
    }

    public static function checkSeries($rollno, $id = 0)
    {
//    $cond = 'Starting';
//    if ($check == 'end') {
//      $cond = 'Ending';
//    }
        return static::where('st_rollno', '<=', floatval($rollno))->where('end_rollno', '>=', floatval($rollno))
            ->where('id', '!=', $id)->get()->first();
    }

    public function rollNo()
    {
        $id = $this->id;
        return "course_id_" . $id;
    }

    public static function nextCourseId($id)
    {
        // return $id;
        $course = static::find($id);
        $nextCourse = null;
        if ($course) {
            $nextCourse = static::where('course_id', '=', $course->course_id)
                ->where('course_year', '=', $course->course_year + 1)
                ->first();
        }
        return $nextCourse ? $nextCourse->id : $id;
    }
}

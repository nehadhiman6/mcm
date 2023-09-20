<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubSectionDetail extends Model
{
    protected $table = 'sub_section_dets';
    protected $fillable = ['sub_sec_id', 'teacher_id', 'sub_subject_name','is_practical'];
    protected $connection = 'yearly_db';

    public function teacher()
    {
        return $this->belongsTo(Staff::class, 'teacher_id', 'id');
    }



    public function sub_section()
    {
        return $this->belongsTo(SubjectSection::class, 'sub_sec_id', 'id');
    }

}

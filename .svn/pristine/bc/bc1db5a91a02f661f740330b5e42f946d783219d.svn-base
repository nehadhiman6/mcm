<?php

namespace App\Models\Activity;

use Illuminate\Database\Eloquent\Model;
use App\Traits;
use Carbon\Carbon;
use App\Models\Activity\AgencyType;
use App\Models\Activity\Orgnization;
use App\Models\Activity\ActivityGuest;

class Activity extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;
    protected $table = 'activities';
    protected $connection = 'mysql';
    protected $fillable =['org_agency_id','start_date','end_date','act_type_id','topic','sponsor_by_id','sponsor_address','college_teachers','college_students','college_nonteaching','outsider_teachers','outsider_students','outsider_nonteaching','remarks','other_remarks','convener','details','sponsor_amt','aegis','act_grp_id'];

    public function setStartDateAttribute($date)
    {
        $this->attributes['start_date'] = Carbon::createFromFormat('d-m-Y', $date);
    }

    public function getStartDateAttribute($date)
    {
        $date = Carbon::parse($date)->format('d-m-Y');
        return $date;
    }

    public function setEndDateAttribute($date)
    {
        $this->attributes['end_date'] = Carbon::createFromFormat('d-m-Y', $date);
    }

    public function getEndDateAttribute($date)
    {
        $date = Carbon::parse($date)->format('d-m-Y');
        return $date;
    }

    public function orgnization()
    {
        return $this->belongsTo(Orgnization::class, 'org_agency_id', 'id');
    }

    public function colloboration()
    {
        return $this->belongsTo(ActivityCollaboration::class, 'id', 'act_id');
    }

    public function acttype()
    {
        return $this->belongsTo(AgencyType::class, 'act_type_id', 'id');
    }

    public function actgrp()
    {
        return $this->belongsTo(AgencyType::class, 'act_grp_id', 'id');
    }

    public function sponsor()
    {
        return $this->belongsTo(AgencyType::class, 'sponsor_by_id', 'id');
    }

    public function guest()
    {
        return $this->hasMany(ActivityGuest::class, 'act_id', 'id')->orderBy('order_no');
    }

    public function setSponsorAmtAttribute($value)
    {
        $this->attributes['sponsor_amt'] = setAmountAttribute($value);
    }
}

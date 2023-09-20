<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Research extends Model
{
    use Traits\ModelUtilities,
        Traits\AutoUpdateUserColumns;

    protected $table = 'researches';
    protected $connection = 'mysql';
    protected $fillable = [
        'staff_id', 'type', 'title1', 'title2', 'title3', 'paper_status',
        'level', 'publisher', 'pub_date','pub_mode','isbn','authorship','institute','ugc_approved','indexing','indexing_other',
        'doi_no','impact_factor','citations','h_index','i10_index','relevant_link','peer_review','res_award'
    ];

    public function setPubDateAttribute($date)
    {
        $this->attributes['pub_date'] = Carbon::createFromFormat('d-m-Y', $date);
    }

    public function getPubDateAttribute($date)
    {
        $date = Carbon::parse($date)->format('d-m-Y');
        return $date;
    }

   
}

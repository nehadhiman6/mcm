<?php

namespace App\Models\Placement;

use Illuminate\Database\Eloquent\Model;
use App\Traits;
use App\State;

class Company extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;
    protected $table = 'placement_companies';
    protected $fillable =['name','add','city','state_id','comp_type','comp_nature'];
    protected $connection = 'mysql';
    
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }
}

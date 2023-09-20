<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits;
use App\User;
use App\Models\Block\Block;

class Location extends Model
{
    use Traits\ModelUtilities,
      Traits\AutoUpdateUserColumns;

    protected $connection = 'mysql';
    protected $table = 'locations';
    protected $fillable = ['location', 'dept_id','type','block_id','is_store','operated_by'];

    public function department()
    {
        return $this->belongsTo('App\Department', 'dept_id', 'id');
    }

    public function block()
    {
        return $this->belongsTo(Block::class, 'block_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'operated_by', 'id');
    }
}

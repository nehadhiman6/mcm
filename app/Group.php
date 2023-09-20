<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits;

class Group extends Model {

  use Traits\ModelUtilities,
      Traits\AutoUpdateUserColumns;

  protected $table = 'groups';
  protected $fillable = ['group_name', 'description'];

  public function permissions() {
    return $this->belongsToMany(Permission::class, 'group_permissions', 'group_id', 'permission_id')->withTimestamps()
        ->select(['permissions.id', 'permissions.name', 'permissions.label']);
  }

}

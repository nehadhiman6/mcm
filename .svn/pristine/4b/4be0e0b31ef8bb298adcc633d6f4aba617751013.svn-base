<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits;

class Permission extends Model {

  use Traits\ModelUtilities,
      Traits\AutoUpdateUserColumns;

  protected $table = 'permissions';
  protected $fillable = ['name', 'label','admin'];

  public function roles() {
    return $this->belongsToMany(Role::class);
  }

  public function groups() {
    return $this->belongsToMany(Group::class, 'group_permissions', 'permission_id', 'group_id')->withTimestamps();
  }

}

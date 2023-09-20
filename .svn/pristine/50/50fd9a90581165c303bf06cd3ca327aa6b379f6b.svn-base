<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits;

class Role extends Model {

  use Traits\ModelUtilities,
      Traits\AutoUpdateUserColumns;

  protected $table = 'roles';
  protected $fillable = ['name', 'label', 'admin'];

  public function users() {
    return $this->belongsToMany(User::class);
  }

  public function permissions() {
    return $this->belongsToMany(Permission::class);
  }

  public function givePermissionTo($permission) {
    return $this->permissions()->save($permission);
  }

}

<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

  use Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name', 'email', 'password',
  ];
  protected $login_fy = '';

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password', 'remember_token',
  ];
  protected $connection = 'mysql';

  public function roles()
  {
    return $this->belongsToMany(Role::class);
  }

  public function hasRole($role)
  {
    if (is_string($role)) {
      return $this->roles->contains('name', $role);
    }

    return !!$role->intersect($this->roles)->count();
  }

  public function isAdmin()
  {
    return $this->id === 1;
  }

  public function staff(){
    return $this->hasOne(Staff::class,'user_id','id');
  }

  public function image(){
    return $this->hasOne(UserImage::class,'user_id','id');
  }
}

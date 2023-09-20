<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\AlmResetPasswordNotification;
use App\Notifications\AlumniActivationNotification;
use DB;
use Illuminate\Notifications\Notifiable;
use App\AlumniStudent;

class AlumniUser extends Authenticatable
{
    use Notifiable;
    
    protected $guard = 'alumnies';
    protected $table = 'alumni_users';
    protected $fillable = ['name','email','password'];
    protected $connection = 'mysql';

    protected $hidden = [
        'password', 'remember_token',
      ];

    public function sendPasswordResetNotification($token)
    {
        return $this->notify(new AlmResetPasswordNotification($token));
    }

    public function sendActivationNotification()
    {
        $token = str_random(15);
        $this->confirmation_code = $token;
        $this->save();
        $this->notify(new AlumniActivationNotification($token));
    }
  

    public function verified()
    {
        $this->confirmed = 1;
        $this->save();
    }

    public function almForm()
    {
         return $this->hasOne(AlumniStudent::class, 'alumni_user_id', 'id');
    }

}

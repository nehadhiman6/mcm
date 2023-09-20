<?php

namespace App\Providers;

use App\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{

  /**
   * The policy mappings for the application.
   *
   * @var array
   */
  protected $policies = [
    'App\Model' => 'App\Policies\ModelPolicy',
  ];

  /**
   * Register any authentication / authorization services.
   *
   * @return void
   */
  public function boot(GateContract $gate)
  {
    $this->registerPolicies($gate);

    $gate->define('student-adm-form', function ($user, $adm_form) {
      return $adm_form->std_user_id == $user->id;
    });

    $gate->define('alumni-student-user', function ($user, $alumni) {
      return $alumni->alumni_user_id == $user->id;
    });

    foreach ($this->getPermissions() as $permission) {
      $gate->define($permission->name, function ($user) use ($permission) {
        if ($user->id == 1)
          return true;
        return $user->hasRole($permission->roles);
      });
    }
  }

  protected function getPermissions()
  {
    return Permission::with('roles')->get();
  }
}

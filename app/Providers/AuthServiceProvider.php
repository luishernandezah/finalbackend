<?php

namespace App\Providers;

use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use  Illuminate\Support\Facades\Gate;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
    // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
      $this->registerPolicies();

      //JWTProvider::define('luis');

      //  $this->register();
    }
    public function register()
    {
        $this->registerPolicies();
        Gate::define('rutapermiso',function(User $users, $query){
            return $users->permisoruta($query);
        });
        Gate::define('permisosadmin',function(User $users, $query){
            return $users->permisosadmin($query);
        });

        Gate::define('permisohistorial',function(User $users, $query){

            return $users->permisohistorial($query);

        });
    }
}

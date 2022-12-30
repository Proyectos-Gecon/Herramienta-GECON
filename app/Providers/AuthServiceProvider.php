<?php

namespace App\Providers;

use App\Models\Team;
use App\Policies\TeamPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Laravel\Fortify\Fortify;
use LdapRecord\Laravel\Auth\BindFailureListener;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Team::class => TeamPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
  

        public function boot()
        {
            $this->registerPolicies();
    
            Fortify::authenticateUsing(function ($request) {
                $validated = Auth::validate([
                    'sAMAccountName' => $request->username,
                    'password' => $request->password
                ]);
    
                return $validated ? Auth::getLastAttempted() : null;
            });

            Gate::before(function ($user, $ability) {
                return $user->hasRole('ADMIN') ? true : null;
            });

        }
    
}

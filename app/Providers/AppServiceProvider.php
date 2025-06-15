<?php

namespace App\Providers;
// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    
    
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        $this->registerPolicies();
        Gate::define('create-artist',function(User $user){
            return $user->role ==='admin';
        });
         Gate::define('update-artist',function(User $user){
            return $user->role ==='admin';
        });
         Gate::define('delete-artist',function(User $user){
            return $user->role ==='admin';
        });
    }
}

<?php

namespace App\Providers;


use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Channel' => 'App\Policies\ChannelPolicy',
        'App\Models\Video' => 'App\Policies\VideoPolicy',
        'App\Models\Comment' => 'App\Policies\CommentPolicy',
        'App\Models\User' => 'App\Policies\UserPolicy',
        'App\Models\Thread' => 'App\Policies\ThreadPolicy',
        'App\Models\Reply' => 'App\Policies\ReplyPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user){
            if($user->name === 'John Doe') return true;
        });
    }
}

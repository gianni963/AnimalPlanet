<?php

namespace App\Providers;

use \App\Models\Topic;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        // \View::composer('forum.threads.create', function ($view) {
        //     $view->with('topics', \App\Models\Topic::all());
        // });
        \View::composer('*', function ($view) {
            $topics = \Cache::rememberForever('topics', function() {
                return Topic::all();
            });

           $view->with('topics', $topics);
        });

        \Validator::extend('spamfree', 'App\Rules\SpamFree@passes');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

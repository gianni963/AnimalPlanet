<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\User::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'active' => 1,
        'admin' => false,
        'admin_title' => null
    ];
});

$factory->state(App\Models\User::class, 'administrator', function() {
    return [
        'admin' => true,
        'admin_title' => 'superadmin'
    ];
});

$factory->define(App\Models\Channel::class, function (Faker $faker){

	return [
		'user_id' => function (){
			return factory ('App\Models\User')->create()->id;
		},
		'name' => $faker->sentence,
		'slug' => $faker->sentence,
		'description' => $faker->sentence
	];
});


$factory->define(App\Models\Thread::class, function ($faker) {

    $title = $faker->sentence;

    return [
        'user_id' => function () {
            return factory('App\Models\User')->create()->id;
        },
        'topic_id' => function () {
            return factory('App\Models\Topic')->create()->id;
        },
        'title' => $title,
        'body'  => $faker->paragraph,
        'visits' => 0,
        'slug' => str_slug($title),
        'locked' => false
    ];
});
$factory->define(App\Models\Topic::class, function ($faker) {

    $name = $faker->word;
    return [
        'name' => $name,
        'slug' => $name

    ];
});

$factory->define(App\Models\Reply::class, function ($faker) {
    return [
        'thread_id' => function () {
            return factory('App\Models\Thread')->create()->id;
        },
        'user_id' => function () {
            return factory('App\Models\User')->create()->id;
        },
        'body'  => $faker->paragraph
    ];
});

$factory->define(\Illuminate\Notifications\DatabaseNotification::class, function ($faker) {
    return [
        'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
        'type' => 'App\Notifications\ThreadWasUpdated',
        'notifiable_id' => function (){
            return auth()->id() ?: factory('App\Models\User')->create()->id;
        },
        'notifiable_type' => 'App\Models\User',
        'data' => ['foo' => 'bar']
    ];
});






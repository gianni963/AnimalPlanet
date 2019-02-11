<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfilesTest extends TestCase
{
	use RefreshDatabase;

	/** @test */

	function a_user_has_a_profile()
	{
        $user = \App\Models\User::create([
            'id' => 1,
            'name' => 'john',
            'email' => 'john@example.com',
            'password' => 'john10',
            'active' => 1 
        ]);
            
        $channel = create('App\Models\Channel', ['user_id' => $user->id]);

		$this->get("/public_profiles/{$user->name}")
			->assertSee($user->name);
	}
	
	/** @test */
	function profiles_display_all_threads_created_by_the_associated_user()
	{
        $user = \App\Models\User::create([
            'id' => 1,
            'name' => 'john',
            'email' => 'john@example.com',
            'password' => 'john10',
            'active' => 1 
        ]);
            
        $channel = create('App\Models\Channel', ['user_id' => $user->id]);

        $this->signIn($user);

        $thread = create('App\Models\Thread', ['user_id' => auth()->id()]);

        $this->get("/public_profiles/" . auth()->user()->name)
            ->assertSee($thread->title)
            ->assertSee($thread->body);
	}

}
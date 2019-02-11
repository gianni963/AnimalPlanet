<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
	use RefreshDatabase;

	/** @test */
	public function a_user_can_fetch_their_most_recent_reply()
	{
		$user = create('App\Models\User');

		$reply = create('App\Models\Reply', ['user_id' => $user->id]);

		$this->assertEquals($reply->id, $user->lastReply->id);
	}

	/** @test */

	function a_user_can_determine_their_avatar_path()
	{
		$user = create('App\Models\User');

		$this->assertEquals(config('petube.buckets.images') . '/avatar/default.png', $user->avatar_path);


		$user->avatar_path ='avatars/me.jpg';

		$this->assertEquals(config('petube.buckets.images') .'/avatar/' . 'avatars/me.jpg', $user->avatar_path);
	}

}
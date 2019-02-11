<?php 

namespace Test\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FavoritesTest extends TestCase
{
	use RefreshDatabase;
	/** @test */
	function guests_can_not_favorite_anything()
	{
		$this->withExceptionHandling()
			->post('/forum/replies/1/favorites')
			->assertRedirect('/login');

	}
	/** @test */
	public function an_authenticated_user_can_favorite_any_reply()
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
		// /replies/id/favorites
		$reply = create('App\Models\Reply');

		//If I post to a "favorite" endpoint
		$this->post('/forum/replies/' . $reply->id . '/favorites');

		//It should be recorded in the database
		$this->assertCount(1, $reply->favorites);
	}

		/** @test */
	public function an_authenticated_user_can_unfavorite_a_reply()
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
		// /replies/id/favorites
		$reply = create('App\Models\Reply');

		$reply->favorite();

		//If I post to a "favorite" endpoint
		$this->post('/forum/replies/' . $reply->id . '/favorites');

		$this->delete('/forum/replies/' . $reply->id . '/favorites');

		//It should be recorded in the database
		$this->assertCount(0, $reply->favorites);
	}
	/** @test */
	function an_authenticated_user_may_only_favorite_a_reply_once()
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
		// /replies/id/favorites
		$reply = create('App\Models\Reply');

		//If I post to a "favorite" endpoint
		try {
			$this->post('/forum/replies/' . $reply->id . '/favorites');	
			$this->post('/forum/replies/' . $reply->id . '/favorites');	
		} catch(\Exception $e) {
			$this->fail('Did not expect to insert the same record set twice.');
		}

		//dd(\App\Models\Favorite::all()->toArray());
		
		$this->assertCount(1, $reply->favorites);

	}
}
<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipateInThreadsTest extends TestCase
{
	use RefreshDatabase;

    /** @test */
    function unauthenticated_users_may_not_add_replies()
    {
		 
        $this->withExceptionHandling()
        	->post('/forum/threads/channel-y/1/replies' ,[])
        	->assertRedirect('/login');
  	
    }

    /** @test */
	function an_authenticated_user_may_participate_in_forum_threads()
	    {
	    	$user = \App\Models\User::create([
		 		'id' => 1,
	            'name' => 'jack',
	            'email' => 'jack@example.com',
	            'password' => 'jack777',
	            'active' => 1 
	        ]);

	        $channel = \App\Models\Channel::create([
		 		'id' => 1,
		 		'user_id' => 1,
	            'name' => 'testChannel',
	            'slug' => 'testing',
	            'description' => 'testing the function'
	        ]);

	        $this->signIn($user);

	        $thread = create('App\Models\Thread');

	        $reply = make('App\Models\Reply'); 


	        $this->post($thread->path().'/replies', $reply->toArray());

	        $this->assertDatabaseHas('replies', ['body' => $reply->body]);
            $this->assertEquals(1, $thread->fresh()->replies_count);
	    }

    /** @test */
    function a_reply_requires_a_body()
    {
        $this->withExceptionHandling()->signIn();
        $thread = create('App\Models\Thread');
        $reply = make('App\Models\Reply', ['body' => null]);
        $this->post($thread->path() . '/replies', $reply->toArray())
             ->assertSessionHasErrors('body');
    }

    /** @test */
    function unauthorized_users_cannot_delete_replies()
   {
        $this->withExceptionHandling();
        $reply = create('App\Models\Reply');
        $this->delete("/forum/replies/{$reply->id}")
            ->assertRedirect('login');
       $this->signIn()
           ->delete("/forum/replies/{$reply->id}")
           ->assertStatus(403);
   }

    /** @test */
    function authorized_users_can_delete_replies()
    {
        $this->signIn();
        $reply = create('App\Models\Reply', ['user_id' => auth()->id()]);
        $this->delete("/forum/replies/{$reply->id}")->assertStatus(302);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
        $this->assertEquals(0, $reply->thread->fresh()->replies_count);
    }

   /** @test */
    function unauthorized_users_cannot_update_replies()
    {
        $this->withExceptionHandling();
        $reply = create('App\Models\Reply');
        $this->patch("/forum/replies/{$reply->id}")
            ->assertRedirect('login');
        $this->signIn()
            ->patch("/forum/replies/{$reply->id}")
            ->assertStatus(403);
    }

    /** @test */
    function authorized_users_can_update_replies()
    {
        $this->signIn();
        $reply = create('App\Models\Reply', ['user_id' => auth()->id()]);
        $updatedReply = 'You been changed, fool.';
        $this->patch("/forum/replies/{$reply->id}", ['body' => $updatedReply]);
        $this->assertDatabaseHas('replies', ['id' => $reply->id, 'body' => $updatedReply]);
    }

    /** @test */

    function replies_that_contain_spam_may_not_be_created()
    {
        $this->withExceptionHandling();
        $this->signIn();
        $thread = create('App\Models\Thread');
        $reply = make('App\Models\Reply', [
            'body' => 'Yahoo Customer Support'
        ]);

        $this->json('post',$thread->path() . '/replies', $reply->toArray())->assertStatus(422);
    }

    /** @test */

    function user_may_only_reply_a_maximim_of_once_per_minute()
    {
        $this->withExceptionHandling();
        $this->signIn();
        $thread = create('App\Models\Thread');

        $reply = make('App\Models\Reply', [
            'body' => 'My simple reply'
        ]);  
        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertStatus(200);           

        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertStatus(429);    

    }
}

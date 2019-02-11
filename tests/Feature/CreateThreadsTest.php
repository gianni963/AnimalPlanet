<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Rules\Recaptcha;
use App\Models\Activity;


class CreateThreadsTest extends TestCase
{
	use RefreshDatabase;

  public function setUp(){

    parent::setUp();

    app()->singleton(Recaptcha::class, function () {

      return \Mockery::mock(Recaptcha::class, function ($m){

        $m->shouldReceive('passes')->andReturn(true);

      });
    });
  }
	/** @test */
	function guests_may_not_create_threads()
	{
		$this->withExceptionHandling();
			
		$this->get('/forum/threads/create')
			->assertRedirect('/login');

		$this->post('/forum/threads')
			->assertRedirect('/login');

	}

    /** @test */
    function an_authenticated_user_can_create_new_forum_threads()
    {
       // given we have a signed in user

		 // $user = \App\Models\User::create([
	 	// 	'id' => 1,
   //          'name' => 'joe',
   //          'email' => 'joe@example.com',
   //          'password' => 'joe777',
   //          'active' => 1 
   //      ]);

			// $channel = \App\Models\Channel::create([
		 // 		'id' => 1,
		 // 		'user_id' => 1,
	  //           'name' => 'testChannel',
	  //           'slug' => 'testing',
	  //           'description' => 'testing the function'
	  //       ]);

   //      $this->actingAs($user);

   //  	//when we hit the endpoint to create the thread page
   //  	$thread = make('App\Models\Thread');

   //  	$response = $this->post('/forum/threads', $thread->toArray() + ['g-recaptcha-response' => 'token']);
    	
   $response = $this->publishThread(['title' => 'Some Title', 'body' => 'some body']);

		$this->get($response->headers->get('Location'))
			->assertSee('Some Title')
			->assertSee('some body');
    }

    /** @test */
    function a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    function a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /** @test */
    function a_thread_requires_recaptcha_verification(){

      unset(app()[Recaptcha::class]);

      $this->publishThread(['g-recaptcha-response' => 'test'])
            ->assertSessionHasErrors('g-recaptcha-response');
    }

    /** @test */
    function a_thread_requires_a_valid_topic()
    {
        factory('App\Models\Topic', 2)->create();

        $this->publishThread(['topic_id' => null])
            ->assertSessionHasErrors('topic_id');
            
        $this->publishThread(['topic_id' => 999])
            ->assertSessionHasErrors('topic_id');
    }

    /** @test */
    function a_thread_requires_a_unique_slug()
    {
      $this->signIn();

      $thread = create('App\Models\Thread', ['title' => 'Foo Title']);
      
      $this->assertEquals($thread->fresh()->slug, 'foo-title');

      $thread = $this->postJson(route('threads'), $thread->toArray() + ['g-recaptcha-response' => 'token'])->json();


      $this->assertEquals("foo-title-{$thread['id']}", $thread['slug']);

    }

    /** @test */
    function a_thread_with_title_that_end_in_a_number_should_generate_the_proper_slug()
    {
      $this->signIn();

      $thread = create('App\Models\Thread', ['title' => 'Some Title 24 ']);

      $thread = $this->postJson(route('threads'), $thread->toArray() + ['g-recaptcha-response' => 'token'])->json();

      $this->assertEquals("some-title-24-{$thread['id']}", $thread['slug']);
    }

    /** @test */
    function unauthorized_users_may_not_delete_threads()
    {
       $this->withExceptionHandling();

       $thread = create('App\Models\Thread');
       
       $this->delete($thread->path())->assertRedirect('/login');

       $this->signIn();
       $this->delete($thread->path())->assertStatus(403);

     
    }
/*    function a_thread_requires_a_title_and_body_to_be_updated()
    {
      $this->withExceptionHandling();

      $this->signIn();

      $thread = create('App\Models\Thread', ['user_id' => auth()->id()]);

      $this->patch($thread->path(), [
          'title' => 'Changed',
        ])->assertSessionHasErrors('body');

      $this->patch($thread->path(), [
          'body' => 'Changed',
      ])->assertSessionHasErrors('title');
    }*/
    /** @test */
/*    function unauthorized_users_may_not_update_threads()
    {
      $this->signIn();

      $thread = create('App\Models\Thread', ['user_id' => create('App\Models\User')->id]);

      $this->patch($thread->path(), [
          'title' => 'Changed',
          'body' => 'Changed body'
        ])->assertStatus(403);
    }*/
    /** @test */
/*    function a_thread_can_be_updated_by_its_creat()
    {
      $this->signIn();

      $thread = create('App\Models\Thread', ['user_id' => auth()->id()]);

      $this->patch($thread->path(), [
          'title' => 'Changed',
          'body' => 'Changed body'
        ]);

      $this->assertEquals('Changed', $thread->fresh()->title);
      $this->assertEquals('Changed body', $thread->fresh()->body);
    }*/

    /** @test */
    function authorized_users_can_delete_threads()
    {
       $this->signIn();

       $thread = create('App\Models\Thread', ['user_id' => auth()->id()]);
       $reply = create('App\Models\Reply', ['thread_id' => $thread->id]);

       $response = $this->json('DELETE', $thread->path());

       $response->assertStatus(204);

       $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
       $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
       
       $this->assertEquals(0, Activity::count());

    }

    protected function publishThread($overrides = [])
    {
        $this->withExceptionHandling()->signIn();

        $thread = make('App\Models\Thread', $overrides);

        return $this->post('/forum/threads', $thread->toArray() + ['g-recaptcha-response' => 'token']);
    }

}

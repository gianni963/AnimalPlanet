<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Redis;

use App\Notifications\ThreadWasUpdated;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;


class ThreadTest extends TestCase
{
	use RefreshDatabase;

	protected $guarded = [];

	public function setUp()
	{
		parent::setUp();
		$this->thread = create('App\Models\Thread');
	}
    /** @test */
    function a_thread_has_a_path()
    {
        $thread = create('App\Models\Thread');
        $this->assertEquals("/forum/threads/{$thread->topic->slug}/{$thread->slug}", $thread->path());
    }

    /** @test */
    function a_thread_has_a_creator()
    {
        $user = \App\Models\User::create([
            'id' => 1,
            'name' => 'joe',
            'email' => 'joe@example.com',
            'password' => 'joe777',
            'active' => 1 
        ]);


        $this->assertInstanceOf('App\Models\User', $this->thread->creator);
    }

	/** @test */
    function a_thread_has_replies()
    {

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }


    /** @test */
    public function a_thread_can_add_a_reply()
    {
                $user = \App\Models\User::create([
            'id' => 1,
            'name' => 'joe',
            'email' => 'joe@example.com',
            'password' => 'joe777',
            'active' => 1 
        ]);
    	$this->thread->addReply([
    		'body' => 'Foobar',
    		'user_id' => 1

    	]);

    	$this->assertCount(1,$this->thread->replies);
    }

    /** @test */
    function a_thread_notifies_all_registered_subscribers_when_a_reply_is_added()
    {
        Notification::fake();

        $this->signIn()->thread->subscribe()->addReply([
            'body' => 'Foobar',
            'user_id' => 999
        ]);

        Notification::assertSentTo(auth()->user(), ThreadWasUpdated::class);
    }

    /** @test */

    function a_thread_belongs_to_a_topic()
    {
        $thread = create('App\Models\Thread');

        $this->assertInstanceOf('App\Models\Topic', $thread->topic);

    }

    /** @test */
    function a_thread_can_be_subscribed_to()
    {
        $thread = create('App\Models\Thread');

        // subscribe with a user_id of one
        $thread->subscribe($userId = 1);

       $this->assertEquals(
            1,
            $thread->subscriptions()->where('user_id', $userId)->count()
         );
    }

     /** @test */
    function a_thread_can_be_unsubscribed_from()
    {
        $thread = create('App\Models\Thread');

        // subscribe with a user_id of one
        $thread->subscribe($userId = 1);

        $thread->unsubscribe($userId);

       $this->assertCount(0, $thread->subscriptions);
    }

    /** @test */

    function it_knows_if_the_authenticated_user_is_subscribed_to_it()
    {
        $thread = create('App\Models\Thread');

        $this->signIn();

        $this->assertFalse($thread->isSubscribedTo);

        $thread->subscribe();

        $this->assertTrue($thread->isSubscribedTo);
    }

    /** @test */

    function a_thread_can_check_if_the_authenticated_user_read_all_replies()
    {
        $this->signIn();

        $thread = create('App\Models\Thread');

        tap(auth()->user(), function($user) use ($thread) {

            $this->assertTrue($thread->hasUpdatesFor($user));

            //Simulate that the user visited the thread.
            
            $user->read($thread);
            
            $this->assertFalse($thread->hasUpdatesFor($user));

        });

    }

    /** @test */
    function a_threads_body_is_sanitized_automatically()
    {
        $thread = make('App\Models\Thread',['body' => '<script>alert("bad")</script><p>This is ok.</p>']);

        $this->assertEquals("<p>This is ok.</p>", $thread->body);
    }

}

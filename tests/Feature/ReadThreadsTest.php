<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadsTest extends TestCase
{
    
    use RefreshDatabase;

    protected $thread;
    public function setUp()
    {
        parent::setUp();
        $this->thread = create('App\Models\Thread');
    }    

    /** @test */
    public function a_user_can_view_all_threads()
    {

        $response = $this->get('/forum/threads')->assertSee($this->thread->title);


    }

    /** @test */

    function a_user_can_see_a_single_thread()
    {
        $this->get($this->thread->path())
            ->assertSee($this->thread->title);
    }



    /** @test */
    function a_user_can_filter_threads_according_to_a_topic()
    {
        $topic = create('App\Models\Topic');
        $threadInTopic = create('App\Models\Thread', ['topic_id' => $topic->id]);
        $threadNotInTopic = create('App\Models\Thread');
        
        $this->get('/forum/threads/' . $topic->slug)
            ->assertSee($threadInTopic->title)
            ->assertDontSee($threadNotInTopic->title);
    }
    /** @test */
    function a_user_can_filter_threads_by_any_username()
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
            
            $threadByJohn = create('App\Models\Thread', ['user_id' => auth()->id()]);
            //dd($threadByJohn);
            $threadNotByJohn = create('App\Models\Thread');
            $this->get('/forum/threads?by=john')
                ->assertSee($threadByJohn->title)
                ->assertDontSee($threadNotByJohn->title);
    }
    /** @test */
    function a_user_can_filter_threads_by_popularity()
    {
        //given we have three threads
        //with 2 replies, 3 replies and 0 replies
        $threadWithTwoReplies = create('App\Models\Thread');
        create('App\Models\Reply', ['thread_id' => $threadWithTwoReplies->id],2);

        $threadWithThreeReplies = create('App\Models\Thread');
        create('App\Models\Reply', ['thread_id' => $threadWithThreeReplies->id],3);

        $threadWithNoReplies = $this->thread;



        //when I filter all thread by popularity
        $response = $this->getJson('/forum/threads?popular=1')->json();
        //the they shoul be returned from most replies to least
        $this->assertEquals([3, 2, 0], array_column($response['data'], 'replies_count'));
    }

    /** @test */
    function a_user_can_filter_threads_by_those_that_are_unanswered()
    {
        $thread = create('App\Models\Thread');
        create('App\Models\Reply', ['thread_id' => $thread->id]);

        $response = $this->getJson('/forum/threads?unanswered=1')->json();
        $this->assertCount(1, $response['data']);
    }
    /** @test */
    function a_user_can_request_all_replies_for_a_given_thread()
    {
        $thread = create('App\Models\Thread');
        create('App\Models\Reply', ['thread_id' => $thread->id], 2);

        $response = $this->getJson($thread->path() . '/replies')->json();

        $this->assertCount(2, $response['data']);
        $this->assertEquals(2, $response['total']);
    }

    /** @test */
    function we_record_a_new_visit_each_time_the_thread_is_read()
    {
        $thread = create('App\Models\Thread');

        $this->assertSame(0, $thread->visits);

        $this->call('GET', $thread->path());

        $this->assertEquals(1, $thread->fresh()->visits);
    }
}

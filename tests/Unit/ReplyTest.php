<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class ReplyTest extends TestCase
{

	use RefreshDatabase;
	

	/** @test */
	function it_has_an_owner()
	 {
        $reply = create('App\Models\Reply');

        $this->assertInstanceOf('App\Models\User', $reply->owner); 
	 }

	 /** @test */
	 function it_knows_if_it_was_just_published()
	 {
        $reply = create('App\Models\Reply');
        
        $this->assertTrue($reply->wasJustPublished());

        $reply->created_at = Carbon::now()->subMonth();

        $this->assertFalse($reply->wasJustPublished());


	 }

	 /** @test */
	 function it_can_detects_all_mentioned_users_in_the_body()
	 {
	 	$reply = new \App\Models\Reply([
	 		'body' =>' @JaneDoe wants to talk to @JohnDoe'
	 	]);

	 	$this->assertEquals(['JaneDoe', 'JohnDoe'], $reply->mentionedUsers());
	 }

	 /** @test */
	 function it_wraps_mentioned_username_in_the_body_within_anchor_tags()
	 {
	 	$reply = new \App\Models\Reply([
	 		'body' =>'Hello @JaneDoe.'
	 	]);

	 	$this->assertEquals(
	 		'Hello <a href="/public_profiles/JaneDoe">@JaneDoe</a>.',
	 			$reply->body
	 		);
	 }

	 /** @test */
	 function it_knows_if_it_is_the_best_reply()
	 {
	 	$reply = create('App\Models\Reply');

	 	$this->assertFalse($reply->isBest());

	 	$reply->thread->update(['best_reply_id' => $reply->id]);

	 	$this->assertTrue($reply->fresh()->isBest());

	 }

 	/** @test */
    function a_reply_body_is_sanitized_automatically()
    {
        $reply = make('App\Models\Reply',['body' => '<script>alert("bad")</script><p>This is ok.</p>']);

        $this->assertEquals("<p>This is ok.</p>", $reply->body);
    }

}

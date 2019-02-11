<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Notifications\YouWereMentioned;

class MentionUsersTest extends TestCase
{
	use RefreshDatabase;

	/** @test */
    public function mentioned_users_in_a_reply_are_notified()
    {
    	$john = create('App\Models\User', ['name' => 'JohnDoe']);
    	$this->signIn($john);

    	$jane = create('App\Models\User', ['name' => 'JaneDoe']);

    	$thread = create('App\Models\Thread');

    	$reply =  make('App\Models\Reply', [
    		'body' => '@JaneDoe look my comment. Also @FrankDoe'
    	]);
    	$this->json('post',$thread->path() . '/replies', $reply->toArray());

    	$this->assertCount(1, $jane->notifications);
    }

    /** @test */
    function it_can_fetch_all_mentioned_users_starting_with_the_given_characters()
    {
        create('App\Models\User', ['name' => 'johndoe']);
        create('App\Models\User', ['name' => 'johndoe2']);
        create('App\Models\User', ['name' => 'janedoe']);

        $results = $this->json('GET','/api/users', ['name' =>'john']);

        $this->assertCount(2, $results->json());
    }
}

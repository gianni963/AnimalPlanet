<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Thread;

class SearchTest extends TestCase
{
	use RefreshDatabase;

	/** @test */
    public function a_user_can_search_threads()
    {
    	config(['scout.driver' => 'algolia']);
    	$search = 'foobar';
        create('App\Models\Thread', [], 2);
        create('App\Models\Thread', ['body' => "A thread with the {$search} term."], 2);

        do {
        	sleep(.25);
        	$results = $this->getJson("/forum/threads/search?q={$search}")->json()['data'];
        } while (empty($results));
        

        $this->assertCount(2, $results);

        Thread::latest()->take(4)->unsearchable();
    }
}

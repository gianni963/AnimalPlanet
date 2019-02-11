<?php
namespace Tests\Feature;

use Illuminate\Support\Facades\Redis;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Thread;
use App\Models\Trending;

class TrendingThreadsTest extends TestCase
{
	use RefreshDatabase;

	protected function setUp()
	{
		parent::setUp();

		$this->trending =  new Trending;

		$this->trending->reset();

	}

	/** @test */
	public function it_increments_a_threads_score_each_time_it_is_read()
	{
		$this->assertEmpty(Redis::zrevrange('testing_trending_threads', 0, -1));

		$thread =  create('App\Models\Thread');

		$this->call('GET', $thread->path());

		$this->assertCount(1, $trending = $this->trending->get());

		$this->assertEquals($thread->title, $trending[0]->title);
	}
}
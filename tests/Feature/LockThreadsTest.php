<?php 

namespace Test\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LockThreadsTest extends TestCase
{
	use RefreshDatabase;

	/** @test */
	function non_administrators_may_not_lock_threads()
	{
		$this->withExceptionHandling();
		
		$this->signIn();

		$thread = create('App\Models\Thread', ['user_id' => auth()->id()]);

		$this->post(route('locked-threads.store', $thread))->assertStatus(403);

		$this->assertFalse(!! $thread->fresh()->locked);
	}
	/** @test */
	function administrators_can_lock_thread()
	{
		$user = factory('App\Models\User')->states('administrator')->create();
		$this->signIn($user);

		$thread = create('App\Models\Thread', ['user_id' => auth()->id()]);

		$this->post(route('locked-threads.store', $thread));

		$this->assertTrue($thread->fresh()->locked, 'Failed asserting that the thread was locked');
		
	}

	/** test */
	function adminsitrators_can_unlocks_threads()
	{
		$user = factory('App\Models\User')->states('administrator')->create();
		$this->signIn($user);

		$thread = create('App\Models\Thread', ['user_id' => auth()->id(), 'locked' => false]);

		$this->delete(route('locked-threads.destroy', $thread));

		$this->assertFalse($thread->fresh()->locked, 'Failed asserting that the thread was unlocked');		
	}

	/** @test */
	public function once_locked_a_thread_may_not_receive_new_replies()
	{
		$this->signIn();
		
		$thread = create('App\Models\Thread', ['locked' => true]);

		$thread->lock();

		$this->post($thread->path() . '/replies', [
			'body' => 'Foobar',
			'user_id' => auth()->id()
		])->assertStatus(422);
	}
}
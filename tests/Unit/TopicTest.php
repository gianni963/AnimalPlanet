<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TopicTest extends TestCase
{

	use RefreshDatabase;
	

	/** @test */
    public function a_topic_consists_of_threads()
    {
        $topic = create('App\Models\Topic');
        $thread = create('App\Models\Thread', ['topic_id' => $topic->id]);
        $this->assertTrue($topic->threads->contains($thread));
    }
}
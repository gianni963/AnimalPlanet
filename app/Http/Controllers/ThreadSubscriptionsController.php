<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thread;

class ThreadSubscriptionsController extends Controller
{
    public function store($topicId, Thread $thread)
    {
    	$thread->subscribe();
    }

    public function destroy($topicId, Thread $thread)
    {
    	$thread->unsubscribe();
    }
}

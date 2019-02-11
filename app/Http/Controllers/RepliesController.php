<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Models\User;
use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\CreatePostRequest;
use App\Notifications\YouWereMentioned;


class RepliesController extends Controller
{
    /**
     * Create a new RepliesController instance.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);
    }

    public function index($topicId, Thread $thread)
    {
        return $thread->replies()->paginate(10);
    }
    /**
     * Persist a new reply.
     *
     * @param  $channelId
     * @param  Thread $thread
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($topicId, Thread $thread, CreatePostRequest $form)
    {   
        if($thread->locked) {
            return response('Thread is locked', 422);
        }

       $reply = $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);

        return $reply->load('owner');
    }

    /**
     * Update an existing reply.
     *
     * @param Reply $reply
     */
    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        request()->validate(['body' => 'required|spamfree']);

        $reply->update(request(['body']));
    }

    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);
        
        $reply->delete();

        if (request()->expectsJson()){
            return response(['status' => 'Reply deleted']);
        }

        return back();
    }

}

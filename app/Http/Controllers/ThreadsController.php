<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redis;

use App\Filters\ThreadsFilters;
use App\Rules\Recaptcha;
use App\Models\Thread;
use App\Models\Topic;
use App\Models\Trending;
use Carbon\Carbon;
use Illuminate\Http\Request;


class ThreadsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @param  Topic $topic
     * @return \Illuminate\Http\Response
     */
    public function index(Topic $topic, ThreadsFilters $filters, Trending $trending)
    {     
        // $threads = Thread::latest();
        // if ($topic->exists) {
        //     $threads->where('topic_id', $topic->id);
        // } 


        // $threads = $threads->filter($filters)->get();

        $threads = $this->getThreads($topic, $filters);

        if(request()->wantsJson()) {
            return $threads;
        }

        return view('forum.threads.index', [

            'threads' => $threads,
            'trending' => $trending->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('forum.threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Recaptcha $ra
     * @return \Illuminate\Http\Response
     */
    public function store(Recaptcha $recaptcha)
    {
        request()->validate([
            'title' => 'required|spamfree',
            'body' => 'required|spamfree',
            'topic_id' => 'required|exists:topics,id',
            'g-recaptcha-response' => ['required', $recaptcha]
        ]);


        $thread = Thread::create([
            'user_id' => auth()->id(),
            'topic_id' => request('topic_id'),
            'title' => request('title'),
            'body' => request('body')
        ]);

        if(request()->wantsJson()){
            return response($thread, 201);
        }

        return redirect($thread->path())
            ->with('flash', 'Your thread has been published!');
    }

    /**
     * Display the specified resource.
     *
     * @param  integer      $topic
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show($topic, Thread $thread, Trending $trending)
    {

        if (auth()->check()) {
            auth()->user()->read($thread);         
        }

        $trending->push($thread);

        $thread->increment('visits');

        return view('forum.threads.show', compact('thread'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer      $topic
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    
    public function update($topic, Thread $thread)
    {

        $this->authorize('update', $thread);
        $data = request()->validate([
            'title' => 'required|spamfree',
            'body' => 'required|spamfree',
        ]);
        $thread->update($data);


    }
    public function destroy($topic, Thread $thread)
    {
        $this->authorize('update', $thread);

        $thread->delete();
        if(request()->wantsJson()){
           return response([], 204);
        }

        return redirect('/forum/threads');
    }
        /**
     * Fetch all relevant threads.
     *
     * @param Topic       $topic
     * @param ThreadFilters $filters
     * @return mixed
     */
    protected function getThreads(Topic $topic, ThreadsFilters $filters)
    {
        $threads = Thread::latest()->filter($filters);
        if ($topic->exists) {
            $threads->where('topic_id', $topic->id);
        }

        return $threads->paginate(11);
    }

}



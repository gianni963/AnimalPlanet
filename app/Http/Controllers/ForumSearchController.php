<?php
namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\Trending;

class ForumSearchController extends Controller
{
    /**
     * Show the search results.
     *
     * @param  \App\Trending $trending
     * @return mixed
     */
    public function show(Trending $trending)
    {

        if (request()->expectsJson()) {

            return Thread::search(request('q'))->paginate(25);
        }

        return view('forum.threads.search', [
            'trending' => $trending->get()
        ]);
    }
}
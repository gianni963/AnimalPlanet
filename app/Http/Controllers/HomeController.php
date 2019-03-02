<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use File;
use App\Models\Video;
use App\Models\User;

use Illuminate\Support\Facades\Redis;

use App\Filters\ThreadsFilters;
use App\Models\Thread;
use App\Models\Topic;
use App\Models\Trending;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, UserRepository $users, Topic $topic, ThreadsFilters $filters,Trending $trending)
    {
      // $file = storage_path() .'/uploads/159f8ac1826128.mp4';
      //   $handle = fopen($file, 'r+');
      //   fclose($handle);
      //   unlink($file);
      
        $threads = $this->getThreads($topic, $filters)->take(4);

        if(request()->wantsJson()) {
            return $threads;
        }
        $trending = $trending->get();
        //dd($trending);
        $subscriptionVideos =  $users->videosFromSubscriptions($request->user());
        $lastestVideos = Video::visible()->lastestFirst()->take(9)->get();
        $carouselVideos = Video::visible()->lastestFirst()->take(3)->get();
        $mostViewedVideos = Video::visible()->lastestFirst()->take(9)->get();
        $lastCatsVideos = Video::visible()
         ->where('title', 'LIKE', "%cat %") 
         ->orWhere('description', 'LIKE', "%cat %")
         ->orWhere('description', 'LIKE', "%cats %")
         ->orWhere('title', 'LIKE', "%cats %")
         ->orWhere('title', 'LIKE', "%kitten%")

         ->lastestFirst()
         ->take(4) 
         ->get();

         $lastDogsVideos = Video::visible()
           ->where('title', 'LIKE', "%dog %") 
           ->orWhere('description', 'LIKE', "%dog %")
           ->orWhere('description', 'LIKE', "%dogs %")
           ->orWhere('title', 'LIKE', "%dogs %")
           ->orWhere('title', 'LIKE', "%puppy%")

           ->lastestFirst()
           ->take(2) 
           ->get();

         $nature = Video::visible()
         ->where('title', 'LIKE', "%flora%") 
         ->orWhere('description', 'LIKE', "%tree%")
         ->orWhere('description', 'LIKE', "%flora%")
         ->orWhere('title', 'LIKE', "%tree%")
         ->orWhere('title', 'LIKE', "%flower%")
         ->orWhere('description', 'LIKE', "%flower%")
         ->lastestFirst()
         ->take(2) 
         ->get();
        

        return view('welcome',compact('subscriptionVideos','lastestVideos', 'threads', 'trending','carouselVideos', 'mostViewedVideos', 'lastCatsVideos', 'lastDogsVideos','nature'));
        

        return view('home',compact('carouselVideos', 'lastestVideos'));
    }

    protected function getThreads(Topic $topic, ThreadsFilters $filters)
    {
        $threads = Thread::latest()->filter($filters);
        if ($topic->exists) {
            $threads->where('topic_id', $topic->id);
        }

        return $threads->paginate(11);

    }
}

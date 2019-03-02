<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redis;

use App\Models\Video;
use Illuminate\Http\Request;
use App\Filters\ThreadsFilters;
use App\Models\Thread;
use App\Models\Topic;
use App\Models\Trending;

class WelcomeController extends Controller
{
    
    public function index(Topic $topic, ThreadsFilters $filters,Trending $trending)
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
        

        return view('welcome',compact('threads', 'lastestVideos', 'carouselVideos', 'mostViewedVideos', 'lastCatsVideos', 'lastDogsVideos','nature', 'trending'));
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

<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use File;
use App\Models\Video;
use App\Models\User;
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
    public function index(Request $request, UserRepository $users)
    {
      // $file = storage_path() .'/uploads/159f8ac1826128.mp4';
      //   $handle = fopen($file, 'r+');
      //   fclose($handle);
      //   unlink($file);
        $subscriptionVideos =  $users->videosFromSubscriptions($request->user());
        $lastestVideos = Video::visible()->lastestFirst()->take(15)->get();
        return view('home',compact('subscriptionVideos', 'lastestVideos'));
    }
}

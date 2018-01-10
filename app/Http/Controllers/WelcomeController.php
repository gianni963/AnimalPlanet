<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;


class WelcomeController extends Controller
{
    
    public function index()
    {
      // $file = storage_path() .'/uploads/159f8ac1826128.mp4';
      //   $handle = fopen($file, 'r+');
      //   fclose($handle);
      //   unlink($file);

        $lastestVideos = Video::visible()->lastestFirst()->take(15)->get();
        return view('welcome',compact('lastestVideos'));
    }
}

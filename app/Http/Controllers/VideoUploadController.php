<?php

namespace App\Http\Controllers;
use Storage;
use File;
use App\Jobs\UploadVideo;

use Illuminate\Support\Carbon;
use Illuminate\Http\Request;


class VideoUploadController extends Controller
{
	public function index()
	{
    	return view('video.upload');
	}

	public function store(Request $request)
	{
		$channel = $request->user()->channel()->first();
		$video = $channel->videos()->where('uid', $request->uid)->firstOrFail();

		// $tmpFile = Storage::temporaryUrl(storage_path() . '/uploads/' . $video->video_filename, Carbon::now()->addMinutes(4));
		
		$request->file('video')->move(storage_path() . '/app/public/', $video->video_filename);

		//$request->file('video')->move($tmpFile, $video->video_filename);
	 	
	 	 $filename =  $video->video_filename;
	 	 
	 	 // $this->dispatch(new UploadVideo(
	 	 // 	$video->video_filename
	 	 // ));
	 	

		//return response()->json(null, 200);

		 $file = storage_path() .'/app/public/' . $filename;
	 	 
	 	Storage::disk('s3drop')->put($filename, $handle = fopen($file, 'r+'));
		return redirect()->route('deleteTmp', ['filename' => $filename]);
	}

	public function deletetmp($filename)
	{
		$file = storage_path() .'/app/public/'. $filename;

		$handle = fopen($file, 'r+');
		fclose($handle);
		unlink($file);

		

	}


}

<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Video;
use App\Models\VideoView;
use Illuminate\Http\Request;

class VideoViewController extends Controller
{
	const BUFFER = 45;


    public function create(Request $request, Video $video)
    {
    	if(!$video->canBeAccessed($request->user())){
    		return;
    	}

    	if($request->user()) {
    		$lastUserView = $video->views()->latestByUser($request->user())->first();

            if($this->withinBuffer($lastUserView)) {
                return;
            }

    	}

    	//last view for given user


    	$lastIp = $video->views()->latestByIp($request->ip())->first();

    	if($this->withinBuffer($lastIp)) {

    		return;
    	}

    	//create video view
    	$video->views()->create([
    		'user_id' => $request->user() ? $request->user()->id : null,
    		'ip' => $request->ip(),
		]);

		return response()->json(null, 200);
    }

    protected function withinBuffer($view)
    {
    	return $view && $view->created_at->diffInSeconds(Carbon::now()) < self::BUFFER;

    }
}

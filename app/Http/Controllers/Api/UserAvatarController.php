<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use File;
use Storage;
use Image;


class UserAvatarController extends Controller
{
    //store a new user avatar
    public function store(Request $request)
    {
    	$this->validate(request(), [
    		'avatar' => ['required', 'image']
    	]);

        //S3

        if ($request->file('avatar')){
            $request->file('avatar')->move(storage_path() . '/uploads', $fileId = uniqid(true));

            $path = storage_path() . '/uploads/' . $fileId;
            $fileName = $fileId . '.png';

            if(Storage::disk('s3images')->put('avatar/' . $fileName, $handle = fopen($path, 'r+'))){

                fclose($handle);

                File::delete($path);

                $user = auth()->user();
                //$user->avatar_path = $fileName;

                //$user->avatar_path->save();
                $user->update([
                    'avatar_path' => $fileName,
                ]);


            }
        }


    	// auth()->user()->update([
    	// 	'avatar_path' => request()->file('avatar')->store('avatars', 'public')
    	// ]);

    	return response([], 204);
    }
}

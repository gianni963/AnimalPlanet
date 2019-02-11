<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Activity;

class PublicProfilesController extends Controller
{
    public function show(User $user)
    {

		return view('publicprofiles.show', [
			'publicProfileUser' => $user,
			'activities' => Activity::feed($user)
		]);

    }
}

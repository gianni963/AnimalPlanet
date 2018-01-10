<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class ActivationController extends Controller
{
    public function activate(Request $request)
    {
    	$user = User::where('email', $request->email)->where('activation_token', $request->token)->firstOrFail();

    	$user->update([
			'active' => true,
			'activation_token' => null 			
		]);

		Auth::loginUsingId($user->id);

		return redirect()->route('home')->withSuccess('Your account is activated! You are now signed in.');
    }
}

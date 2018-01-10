<?php

namespace App\Http\Controllers\Auth;

use App\Events\Auth\UserRequestedActivationEmail;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
class ActivationResendController extends Controller
{
    public function showResendForm()
    {
    	return view('auth.activate.resend');
    }

    public function resend(Request $request)
    {
    	$this->validateResendRequest($request);

    	$user = User::where('email', $request->email)->first();

    	event(new UserRequestedActivationEmail($user));

    	return redirect()->route('login')
    		->withSucces('Account activation email has been resent.');
    }

    protected function validateResendRequest(Request $request)
    {
    	$this->validate($request, [
    		'email' => 'required|email|exists:users,email'
		], [

			'emails.exists' => 'Could not find that account.'
		]);
    }
}

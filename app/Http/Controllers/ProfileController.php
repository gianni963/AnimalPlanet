<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Models\User;
use App\Models\Channel;


class ProfileController extends Controller
{

    
    public function index(User $user, Channel $channel)
    {
    	//private profile
    	$user = Auth::user();
    	return view('profile.index',[

    		'user' => $user,   		

		]);
    }

    public function update(Request $request, User $user)
    {
        $this->validate($request, [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,'.Auth::user()->id,
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;

        $user->save();

        return back()->withSuccess("Informations updated!");
    }

    public function getDeleteAccount(User $user, Channel $channel)
    {
        //private profile
        $user = Auth::user();
        return view('profile.deleteAccount',[

            'user' => $user,        

        ]);
    }

    public function postDeleteAccount(User $user)
    {
        $user = User::find(Auth::user()->id);
        Auth::logout();

        if($user->delete()) {
            return redirect()->route('welcome')
            ->withSucces('Your account has been deleted.');
        }
    }


}
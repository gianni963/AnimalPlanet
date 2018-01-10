<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use Session;

class ContactController extends Controller
{
    public function index()
    {
    	return view('informations.contact');

    }

    public function postContact(Request $request)
    {
    	$this->validate($request, [
    		'email' => 'required|email',
    		'subject' => 'min:3',
    		'message' => 'min:10'
		]);

    	$datas = array(
    		'email' => $request->email,
    		'subject' => $request->subject,
    		'bodyMessage' => $request->message 
    		);

		Mail::send('emails.contact', $datas, function($message) use ($datas){
			$message->from($datas['email']);
			$message->to('gianni_guatieri@hotmail.com');
			$message->subject($datas['subject']);
		});

		Session::flash('success', 'Your Email was sent!');

		return redirect()->route('welcome');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class UserNotificationsController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		return auth()->user()->unreadNotifications->take(12);
	}
	
	public function destroy(User $user, $notificationId)
	{
		auth()->user()->notifications()->findOrFail($notificationId)->markAsRead();
	}
}

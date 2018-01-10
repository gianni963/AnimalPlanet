<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends controller
{
    public function index()
    {
    	return view('admin.users.index');
    }
}

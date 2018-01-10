<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChannelController extends controller
{
    public function index()
    {
    	return view('admin.channels.index');
    }
}

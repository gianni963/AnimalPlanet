<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VideoController extends controller
{
    public function index()
    {
    	return view('admin.videos.index');
    }
}

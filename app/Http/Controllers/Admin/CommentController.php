<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends controller
{
    public function index()
    {
    	return view('admin.comments.index');
    }
}

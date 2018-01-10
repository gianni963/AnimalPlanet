<?php

namespace App\Http\Controllers\DataTable;

use App\Http\Controllers\Datatable\DataTableController;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Http\Controllers\Controller;

use Illuminate\Validation\Rule;


class CommentController extends DataTableController
{
    protected $allowCreation = true;
    protected $allowDeletion = true;
    public function builder()
    {
    	return Comment::query();
    }

    public function getDisplayableColumns()
    {
        return [
            'id' ,'body', 'user_id', 'reply_id', 'commentable_id', 'commentable_type', 'created_at'
        ];
    }    

    public function getUpdatableColumns()
    {
        return [
          'body', 'user_id', 'reply_id', 'commentable_id', 'commentable_type', 'created_at'
        ];
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'body' => 'required|max:900',
            'user_id' => 'required',
            'commentable_id' => 'required',
            'commentable_type' => 'required',
        ]);

        
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
        	'body' => 'required'
        ]);
        $this->builder->find($id)->update($request->only($this->getUpdatableColumns()));
    }
}
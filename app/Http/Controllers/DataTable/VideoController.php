<?php

namespace App\Http\Controllers\DataTable;

use App\Http\Controllers\Datatable\DataTableController;
use Illuminate\Http\Request;
use App\Models\Video;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;


class VideoController extends DataTableController
{
    protected $allowCreation = false;
     protected $allowDeletion = true;
    
    public function builder()
    {
    	return Video::query();
    }

    public function getDisplayableColumns()
    {
        return [
            'id' ,'title', 'description', 'processed','visibility', 'allow_votes', 'allow_comments', 'created_at'
        ];
    }    

    public function getUpdatableColumns()
    {
        return [
            'title', 'description', 'processed','visibility', 'allow_votes', 'allow_comments', 'created_at'
        ];
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'title' =>'required',
            'description' => 'nullable',
            'processed' => 'boolean',
            'visibility' =>  [ 
                'required', Rule::in(['public', 'unlisted', 'private'
                ]),
            ],
            'allow_votes' => 'boolean',
            'allow_comments' => 'boolean',
        ]);
        $this->builder->find($id)->update($request->only($this->getUpdatableColumns()));
    }
}
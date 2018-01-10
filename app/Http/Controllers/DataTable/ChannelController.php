<?php

namespace App\Http\Controllers\DataTable;

use App\Http\Controllers\Datatable\DataTableController;
use Illuminate\Http\Request;
use App\Models\Channel;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;


class ChannelController extends DataTableController
{
    protected $allowCreation = false;
     protected $allowDeletion = true;
    
    public function builder()
    {
    	return Channel::query();
    }

    public function getDisplayableColumns()
    {
        return [
            'id' ,'user_id','name', 'slug', 'description', 'image_filename', 'created_at', 'updated_at'
        ];
    }    

    public function getUpdatableColumns()
    {
        return [
          'user_id','name', 'slug', 'description' 
        ];
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required',
            'name' => 'required',
            'slug' => 'required',
        	'description' => 'nullable:channels,description',
        ]);
        $this->builder->find($id)->update($request->only($this->getUpdatableColumns()));
    }
}
<?php

namespace App\Http\Controllers\DataTable;

use App\Http\Controllers\Datatable\DataTableController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;

class UserController extends DataTableController
{
    protected $allowCreation = false;
    protected $allowDeletion = true;
    public function builder()
    {
    	return User::query();
    }

    public function getDisplayableColumns()
    {
        return [
            'id', 'name', 'email', 'created_at'
        ];
    }

    public function getCustomColumnNames()
    {
        return [
           'name' => 'full name' 
        ];
    }    

    public function getUpdatableColumns()
    {
        return [
            'name', 'email', 'created_at'
        ];
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' =>'required',
            'email'=>'required|email|unique:users,email,'.$id,
        ]);
        $this->builder->find($id)->update($request->only($this->getUpdatableColumns()));
    }
}

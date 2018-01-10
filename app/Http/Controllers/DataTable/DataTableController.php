<?php

namespace App\Http\Controllers\DataTable;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;


abstract class DataTableController extends Controller
{
    /**
        If an entity is allowed to be created
    **/
    protected $allowCreation = true;

    /**
        If an entity is allowed to be deleted
    **/
    protected $allowDeletion = true;

	protected $builder;

    abstract public function builder();

    public function __construct()
    {
    	$builder = $this->builder();

    	if (!$builder instanceof Builder){
    		throw new Exception('Entity builder not instance of Builder');
    	}

    	$this->builder = $builder;
    }

    public function index(Request $request)
    {
    	
    	return response()->json([
    		'data' => [
                'table' => $this->builder->getModel()->getTable(),
                'custom_columns' => $this->getCustomColumnNames(),
                'displayable' => array_values($this->getDisplayableColumns()),
    			'updatable' => array_values($this->getUpdatableColumns()),
    			'records' => $this->getRecords($request),
                'allow' => [
                    'creation' => $this->allowCreation,
                    'deletion' => $this->allowDeletion,
                ]
    		]
		]);
    }

    public function update($id, Request $request)
    {
        $this->builder->find($id)->update($request->only($this->getUpdatableColumns()));
    }

    public function destroy($id, Request $request)
    {
        if(!$this->allowDeletion) {
            return;
        }
        $this->builder->find($id)->delete();
    }

    public function store(Request $request)
    {
        if(!$this->allowCreation) {
            return;
        }

        $this->builder->create($request->only($this->getUpdatableColumns()));
    }

    public function getDisplayableColumns()
    {
        return array_diff($this->getDatabaseColumnNames(), $this->builder->getModel()->getHidden());
    } 

    public function getCustomColumnNames()
    {
        return [];
    }
    public function getUpdatableColumns()
    {
        return $this->getDisplayableColumns();
    }

    protected function getDatabaseColumnNames()
    {
    	return Schema::getColumnListing($this->builder->getModel()->getTable());
    }

    protected function getRecords(Request $request)
    {
        $builder = $this->builder;

        if ($this->hasSearchQuery($request)) {
            $builder = $this->buildSearch($builder, $request);
        }
        try{
            return $this->builder->limit($request->limit)->orderBy('id', 'asc')->get($this->getDisplayableColumns());

        } catch (QueryException $e){
            return [];
        }
    }

    protected function hasSearchQuery(Request $request)
    {
        return count(array_filter($request->only(['column', 'operator', 'value']))) === 3;
    }

    protected function buildSearch(Builder $builder, Request $request)
    {
       $queryParts = $this->resolveQueryParts($request->operator, $request->value);
       
       return $builder->where($request->column, $queryParts['operator'], $queryParts['value']);
    }

    protected function resolveQueryParts($operator, $value)
    {
        return array_get([
            'equals' => [
                'operator' => '=',
                'value' => $value
            ],      
            'contains' => [
                'operator' => 'LIKE',
                'value' => "%{$value}%"
            ],
            'starts_with' => [
                'operator' => 'LIKE',
                'value' => "{$value}%"
            ],
            'ends_with' => [
                'operator' => 'LIKE',
                'value' => "%{$value}"
            ],
            'greater_than' => [
                'operator' => '>',
                'value' => $value
            ],
            'less_than' => [
                'operator' => '<',
                'value' => $value
            ]
        ], $operator);
    }

}